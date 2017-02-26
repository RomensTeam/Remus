<?php

/**
 * VarAppController
 *
 * @author Roman
 */
class VarAppController {
    
    /**
     * 
     * @var RUsers\Main
     */
    public $RUsers;
    
    /**
     * 
     * @var RUsers/User
     */
    public $User = false;
    
    /**
     * 
     * @var VK\VK
     */
    public $VK = null;
    public $vk_url = 'http://balloons.romens.ru/verify';
    
    


    public function __set($name,$value) {
        Remus::Model()->var_app[$name] = $value;
    }
    
    public function __get($name) {
        return Remus::Model()->var_app[$name];
    }
    
    public function __unset($name) {
        unset(Remus::Model()->var_app[$name]);
    }
    
    /**
     * @param RUsers/User $user
     */
    public function userImage($user) {
        $image = $user->getImage();
        if(!empty($image)){
            return $image;
        }
        
        $id = $user->getID();
        
        if(file_exists(DIR_USERS.$id._DS.'100.png')){
            return URL.'files/users/'.$id._DS.'100.png';
        } else {
            $email = $user->getEmail();
            return "https://www.gravatar.com/avatar/".md5(strtolower(trim($email)))."?d=".urlencode( 'placehold.it/100')."&s=100";
        }
    }
    
    public function userURL($id) {
        return URL.'users/'.$id.'/';
    }
    
    public function projectURL($id) {
        return URL.'projects/'.$id.'/';
    }
    
    public function ProjectImage($id){
        return NULL;
        $project_image = 'http://placehold.it/100.png';
        $array = array(
            'files'._DS.'projects'._DS.$id._DS.'image_sm_'.$id.'.png',
            'files'._DS.'projects'._DS.$id._DS.'image_sm_'.$id.'.jpeg'
        );
        foreach ($array as $value) {
            if(is_file(DIR.$value)){
                $project_image = _urlen(URL.$value);
            }
        }
        return (string) $project_image;
    }
    
    public function StartApp($name) {
        $name = strtolower($name);
        $this->RUsers = new RUsers\Main();
        
        $block = 'header_no_auth';
        if(RUsers\Main::$User) {
            $this->User =$this->RUsers->UserProfile;
            $block = 'header_auth';
            var_app(array(
                'this_user_id' => $this->User->getID(),
                'this_user_login' => $this->User->getLogin(),
                'this_user_name' => $this->User->getName(),
                'this_user_url' => $this->userURL($this->User->getID()),
                'this_user_status' => $this->User->getStatus(),
                'this_user_email' => $this->User->getEmail(),
                'this_user_image' => $this->userImage($this->User)
            ));
            #$this->VK = new \VK\VK(VK_ID, VK_KEY,  $this->User->getToken());
        } else {
           #$this->VK = new \VK\VK(VK_ID, VK_KEY);
        }
        #$this->VK->setApiVersion(5.62);
        $this->header_area = M()->getBlock($block);
        
        M()->app_lang('ru-RU',$name.',main,footer,header');

        $meta = array(
            'title'         => app_lang($name.'_title'),
            'description'   => app_lang($name.'_desc'),
            'keywords'      => app_lang($name.'_keywords')
        );
        Remus()->startApp();
        Remus::View()->meta = $meta;
    }
}
