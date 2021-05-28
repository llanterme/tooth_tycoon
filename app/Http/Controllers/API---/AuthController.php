<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Repository\BaseController;
use App\Http\Repository\CustomEncryption;
use App\Http\Repository\SendMail as SendMail;
use File;
use Log;
use Auth;
use Storage;
use Carbon\Carbon;
use URL;

class AuthController extends Controller
{
    public function __construct(BaseController $baseController)
    {
        $this->baseController=$baseController;
        $this->mail=new SendMail();
        $this->customencryption = new CustomEncryption();
    }

    public function register(Request $request)
    {
        if($request->has('email'))
        {
            $request->merge([
                'email' => $this->customencryption->decryption($request->email)
            ]);
        }
        if($request->has('name'))
        {
            $request->merge([
                'name' => $this->customencryption->decryption($request->name)
            ]);
        }
        if($request->has('password'))
        {
            $request->merge([
                'password' => $this->customencryption->decryption($request->password)
            ]);
        }
        if($request->has('password_confirmation'))
        {
            $request->merge([
                'password_confirmation' => $this->customencryption->decryption($request->password_confirmation)
            ]);
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        $validatedData['password']= bcrypt($request->password);
        $user = User::create($validatedData);
        $user->accessToken=$user->createToken('authToken')->accessToken;

        $resmail=$this->mail->WelcomeMailSend($request->email,$request->name);

        return $this->baseController->ResponseJson('1','Login Success',$user,201);
    }

    public function reset(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required',
            'code' => 'required',
	        'password' => 'required|confirmed'
        ]);

        $user = User::where('email',$request->email)->where('remember_token',$request->code)->first();
        if(!empty($user))
        {
            $user->password=($request->password);
            $user->email_verified_at=date('Y-m-d H:m:s');
            $user->save();
            $data=array(['user_detail'=>$user]);
            return $this->baseController->ResponseJson(1,'Update Your Password.',$data,200);
        }
        else
        {
            return $this->baseController->ResponseJson(0,'Invalid Email or Code.',"",200);
        }
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'email|required'
        ]);

        $user=User::where('email',$request->email)->first();
        if(!empty($user))
        {

            $code=Str::random(6);
            $user->remember_token=$code;
            $user->save();
            $to_email1 = 'jasmin';
            $to_email = $request->email;
            $data = array('sender'=>"Teeth Application ", "body" => "Reset Your Password" ,"code"=>$code,"user"=>$user);
            Mail::send('email.mail', $data, function($message) use ($to_email1, $to_email) {
            $message->to($to_email)->subject('Teeth Application');
            $message->from('jasmin@orainfotech.com','jasmin shukal');
            });

            Log::info('User Forgot', ['user_detail' => $user]);
            return $this->baseController->ResponseJson(1,'Send Code SuccessFully.','',200);
        }
        else
        {
            return $this->baseController->ResponseJson(0,'Email not Found.','',200);
        }

    }

    public function login(Request $request)
    {
        if($request->has('email'))
        {
            $request->merge([
                'email' => $this->customencryption->decryption($request->email)
            ]);
        }
        if($request->has('password'))
        {
            $request->merge([
                'password' => $this->customencryption->decryption($request->password)
            ]);
        }

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
            'device_id'=>'required',
            'fcm_token'=> 'required'
        ]);

        unset($loginData['device_id']);
        unset($loginData['fcm_token']);
        if (!auth()->attempt($loginData)) {
            return $this->baseController->ResponseJson(0,'Invalid Credentials',"",401);
        }

        $user=auth()->user();
        $user->device_id=$request->device_id;
        $user->fcm_token=$request->fcm_token;
        $user->save();

        $user->photo=asset($user->photo);

        $request->user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        $user->accessToken=auth()->user()->createToken('authToken')->accessToken;
        Log::info('User Login', ['user_login' => $user]);
        return $this->baseController->ResponseJson(1,'Login Successfully',$user,200);
    }

    public function ProfileUpdate(Request $request)
    {
        $loginData = $request->validate([
            'name' => 'required',
        ]);

        $user=$request->user();
        $update_user=User::find($user->id);
        if(isset($request->name))
        {
            $update_user->name=$request->name;
        }

        if(isset($request->phone))
        {
            $update_user->phone=$request->phone;
        }

        if($request->hasFile('image'))
        {
            if($update_user->photo!="storage/profile/default.png")
            {
                $old_file_path = str_replace('storage/','',$update_user->photo);
                Storage::delete($old_file_path);
            }
            $update_user->photo='storage/'.$request->file('image')->store('profile');
        }

        if(!empty($request->base_img))
        {

            if($update_user->photo!="default.png")
            {
                $path = public_path()."/user/profile/".$update_user->photo;
                if(file_exists($path))
                {
                    unlink($path);
                }
            }

            $base64_image = $request->base_img;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_image))
            {
                $data = substr($base64_image, strpos($base64_image, ',') + 1);
                $data = base64_decode($data);
                $code = Carbon::now()->timestamp;
                $file_name=$code.'.jpg';
                $path_with_name_file_name=public_path("user/profile/");
                $path_with_name_file_name=$path_with_name_file_name.$file_name;
                // dd($path_with_name_file_name);
                File::put($path_with_name_file_name, $data);

                $update_user->photo=$file_name;
            }
        }
        $update_user->save();
        $update_user->photo=asset($update_user->photo);
        $data=$update_user;
        return $this->baseController->ResponseJson("1","Save Successfully",$data);
    }

    public function Profile(Request $request)
    {
        $user=$request->user();
        if($user->photo=="default.png")
        {
            // $user->photo="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={$user->name}";
            $user->photo=URL::to('user/profile')."/".$user->photo;
        }
        else
        {
            $user->photo=URL::to('user/profile')."/".$user->photo;
        }
        return $user;
    }

    public function ChangePassword(Request $request)
    {
        $loginData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
        $user=$request->user();
        if (Hash::check($request->old_password, $user->password))
        {
            $user->password=bcrypt($request->new_password);
            $user->save();
            return $this->baseController->ResponseJson(1,'Change Password Successfully',$user,200);
        }else
        {
            return $this->baseController->ResponseJson(1,'Invalid Password',[],200);
        }
    }

    public function Remove(Request $request)
    {
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return response()->json('Successfully logged out');
    }

    public function social_login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'social_id' => 'required',
            'name' => 'required',
            'device_id'=> 'required',
            'fcm_token'=> 'required',
            'social_name'=> 'required',
        ]);
        $finduser = User::where('email',$request->email)->where('social_id', $request->social_id)->where('social_name', $request->social_name)->first();
        if(!empty($finduser))
        {
            Auth::loginUsingId($finduser->id);
            $user=auth()->user();
            $user->device_id=$request->device_id;
            $user->fcm_token=$request->fcm_token;
            $user->save();

            $request->user()->tokens->each(function($token, $key) {
                $token->delete();
            });

            $user->accessToken=$finduser->createToken('authToken')->accessToken;
            return $this->baseController->ResponseJson(1,'Login Successfully',$user,200);

        }
        else
        {

            $validatedData['name'] = $request->name;
            $validatedData['email'] = $request->email;
            $validatedData['social_id'] = $request->social_id;
            $validatedData['social_name'] = $request->social_name;
            $validatedData['password'] = bcrypt("test_pass");
            $user = User::create($validatedData);
            $user->accessToken=$user->createToken('authToken')->accessToken;
            return $this->baseController->ResponseJson('1','Register Success',$user,201);
        }
        // if (!auth()->attempt($loginData)) {
        //     return $this->baseController->ResponseJson(0,'Invalid Credentials',"",401);
        // }
        return $request;
    }
}
