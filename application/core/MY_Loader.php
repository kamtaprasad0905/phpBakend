<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Loader extends CI_Loader {
   public function front($template_name, $vars = array(), $return = FALSE){
        if($return):
            $content  = $this->view('template/header', $vars, $return);
            $content .= $this->view('template/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('template/footer', $vars, $return);
            return $content;
        else:
            $this->view('template/header', $vars);
            $this->view($template_name, $vars);
            $this->view('template/footer', $vars);
        endif;
    }
     /*public function sellerfront($template_name, $vars = array(), $return = FALSE){
        if($return):
            $content  = $this->view('template/sellerheader', $vars, $return);
            $content .= $this->view('template/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('template/sellerfooter', $vars, $return);
            return $content;
        else:
            $this->view('template/sellerheader', $vars);
            $this->view($template_name, $vars);
            $this->view('template/sellerfooter', $vars);
        endif;
    }  */
  public function admin($template_name, $vars = array(), $return = FALSE){
        if($return):
            $content  = $this->view('template/header', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('template/footer', $vars, $return);
            return $content;
        else:
            $this->view('template/header', $vars);
            $this->view($template_name, $vars);
            $this->view('template/footer', $vars);
        endif;
    }
    public function dbfront($template_name, $vars = array(), $return = FALSE){
        if($return):
            $content .= $this->view('template/db_header', $vars, $return);
            $content .= $this->view('/'.$template_name, $vars, $return);
            $content .= $this->view('template/footer', $vars, $return);
            return $content;
        else:
          //  $this->view('template/header', $vars);
            $this->view('template/db_header', $vars);
            $this->view('/'.$template_name, $vars);
            $this->view('template/footer', $vars);
        endif;
    }
}
?>

