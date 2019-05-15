<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //对称加密
    public function passwords(){
        $plaintext = '12345abc';
//        echo $plaintext;die;
//        $plaintext = json_encode($plaintext);
        $cipher = "AES-256-CBC";
        $tag = "zzxxcc";
        $options = OPENSSL_RAW_DATA;
        $iv = "qwertyuioplkjhgf";
        $ciphertext = openssl_encrypt($plaintext, $cipher, $tag, $options, $iv);
//        echo $ciphertext; echo "<hr>";
        $ciphertext = base64_encode($ciphertext);
//        echo $ciphertext;die;
        $url = "http://vm.lumen.com/passwords";

        $ch = curl_init();
        //字符串文本
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$ciphertext);


        $data = curl_exec($ch);
        echo $data;
        //关闭curl资源，并释放系统内存
        curl_close($ch);

    }
    //凯撒加密
    public function pwd(){
        $str = "asd";
        $data = '';
        $length = strlen($str);
        for($i=0;$i<$length;$i++){
            $int = ord($str[$i])+3;
            $data .= chr($int);
        }

        $url = "http://vm.lumen.com/pwd";

        $ch = curl_init();
        //字符串文本
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);


        $data = curl_exec($ch);
        echo $data;
        //关闭curl资源，并释放系统内存
        curl_close($ch);
    }
    //非对称加密
    public function jyg(){
        $data = [
            'name'=>'兰聪',
            'age'=>'19',
        ];
        $json_str = json_encode($data);
        $key = openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json_str,$en_data,$key);
        $en_data=base64_encode($en_data);
        $url = "http://vm.lumen.com/jyg";

        $ch = curl_init();
        //字符串文本
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$en_data);


        $data = curl_exec($ch);
        echo $data;
        //关闭curl资源，并释放系统内存
        curl_close($ch);
    }
    //签名加密
    public function lc(){
        $data = [
            'id'=>'400',
            'tittle'=>'订单',
            'time'=>time()
        ];
        $str_data = json_encode($data);

        $key = openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_sign($str_data,$signature,$key);
        $b64=base64_encode($signature);

        $url = 'http://vm.lumen.com/lc?sign='.urlencode($b64);
//        echo $url;die;
        $ch = curl_init();
        //字符串文本
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str_data);
//        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);

        $data = curl_exec($ch);
        $error_code = curl_errno($ch);
        echo $data;
        //关闭curl资源，并释放系统内存
        curl_close($ch);
    }

    //注册
    public function regi(){
        return view('user.reg');
    }
    public function reg(Request $request){
        header("Access-Control-Allow-Origin: *");
//        echo 111;die;
        $user_name = $request->input('username');
        $user_pwd1 = $request->input('password1');
        $user_pwd2 = $request->input('password2');
        $user_email = $request->input('email');
        $data = [
            'user_name'=>$user_name,
            'user_email'=>$user_email,
            'user_pwd1'=>$user_pwd1,
            'user_pwd2'=>$user_pwd2,
        ];
        $json_str = json_encode($data);
        $key = openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json_str,$en_data,$key);
        $en_data=base64_encode($en_data);
        $url = "http://vm.lumen.com/reg";

        $ch = curl_init();
        //字符串文本
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$en_data);


        $data = curl_exec($ch);
        echo $data;
        //关闭curl资源，并释放系统内存
        curl_close($ch);
    }
    //登录
    public function login(){
        return view('user/login');
    }
    public function doLogin(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        $user_email = $request->input('username');
        $user_pwd = $request->input('password');
        $data = [
            'user_email' => $user_email,
            'user_pwd' => $user_pwd
        ];
        $json_str = json_encode($data);
//        print_r($json_str);
        $key = openssl_pkey_get_private('file://' . storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json_str, $en_data, $key);
        $en_data = base64_encode($en_data);
//        print_r($en_data);die;
        $url = "http://vm.lumen.com/doLogin";

        $ch = curl_init();
        //字符串文本
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $en_data);


        $data = curl_exec($ch);
        echo $data;
        //关闭curl资源，并释放系统内存
        curl_close($ch);
    }
}
