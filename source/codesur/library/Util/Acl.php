<?php
class Util_Acl extends Zend_Acl {

  public function __construct() {
  
	/*default*/
  	  	
  	
    $this->add(new Zend_Acl_Resource('default:captcha'));
    $this->add(new Zend_Acl_Resource('default:error'));   
    $this->add(new Zend_Acl_Resource('default:index'));    
    $this->add(new Zend_Acl_Resource('default:estatico'));

    $this->add(new Zend_Acl_Resource('default:noticias'));
    $this->add(new Zend_Acl_Resource('default:grupo'));
    $this->add(new Zend_Acl_Resource('default:proveedores'));
    $this->add(new Zend_Acl_Resource('default:certificaciones'));
    $this->add(new Zend_Acl_Resource('default:msitio'));    
    $this->add(new Zend_Acl_Resource('default:indexbo'));
    $this->add(new Zend_Acl_Resource('default:socios'));
    $this->add(new Zend_Acl_Resource('default:distribucion'));
    $this->add(new Zend_Acl_Resource('default:elegir'));
    $this->add(new Zend_Acl_Resource('default:recetas'));
    $this->add(new Zend_Acl_Resource('default:contactobo'));
        $this->add(new Zend_Acl_Resource('default:noticiasbo'));
//    $this->add(new Zend_Acl_Resource('default:contactobo'));
    $this->add(new Zend_Acl_Resource('default:voluntariado'));
    $this->add(new Zend_Acl_Resource('default:organizacion'));
    
$this->add(new Zend_Acl_Resource('default:paises'));
$this->add(new Zend_Acl_Resource('default:recintos'));
$this->add(new Zend_Acl_Resource('default:calendario'));
$this->add(new Zend_Acl_Resource('default:historia'));
$this->add(new Zend_Acl_Resource('default:convocatoria'));
$this->add(new Zend_Acl_Resource('default:deportes'));
$this->add(new Zend_Acl_Resource('default:contacto'));
$this->add(new Zend_Acl_Resource('default:imagenes'));
$this->add(new Zend_Acl_Resource('default:videos'));
$this->add(new Zend_Acl_Resource('default:mascotas'));
$this->add(new Zend_Acl_Resource('default:mapas'));
$this->add(new Zend_Acl_Resource('default:pdf'));
$this->add(new Zend_Acl_Resource('default:contrataciones'));
    
/*admin*/

     $this->add(new Zend_Acl_Resource('admin:administrador'));
     $this->add(new Zend_Acl_Resource('admin:usuario'));
     $this->add(new Zend_Acl_Resource('admin:captcha'));
     $this->add(new Zend_Acl_Resource('admin:bannerimg'));
     $this->add(new Zend_Acl_Resource('admin:galeriavideos'));
     $this->add(new Zend_Acl_Resource('admin:galeriafotos'));

     $this->add(new Zend_Acl_Resource('admin:estatico'));
     $this->add(new Zend_Acl_Resource('admin:proveedores'));
     $this->add(new Zend_Acl_Resource('admin:organizacion'));
     $this->add(new Zend_Acl_Resource('admin:rotador'));
     $this->add(new Zend_Acl_Resource('admin:noticia'));
     $this->add(new Zend_Acl_Resource('admin:noticiabo'));
     $this->add(new Zend_Acl_Resource('admin:marca'));
     $this->add(new Zend_Acl_Resource('admin:video'));
     $this->add(new Zend_Acl_Resource('admin:recintos'));
     $this->add(new Zend_Acl_Resource('admin:paises'));
       $this->add(new Zend_Acl_Resource('admin:historia'));
          $this->add(new Zend_Acl_Resource('admin:index'));
          $this->add(new Zend_Acl_Resource('admin:convocatorias'));
               $this->add(new Zend_Acl_Resource('admin:contactos'));
                    $this->add(new Zend_Acl_Resource('admin:voluntariado'));
       $this->add(new Zend_Acl_Resource('admin:secciones'));
       $this->add(new Zend_Acl_Resource('admin:mascotas'));
       $this->add(new Zend_Acl_Resource('admin:voluntariadotipo'));
       $this->add(new Zend_Acl_Resource('admin:deportes'));
       $this->add(new Zend_Acl_Resource('admin:voluntariadopreguntas'));
       $this->add(new Zend_Acl_Resource('admin:pdf'));
	   $this->add(new Zend_Acl_Resource('admin:link'));
           $this->add(new Zend_Acl_Resource('admin:contrataciones'));
             $this->add(new Zend_Acl_Resource('admin:voluntariadobeneficios'));
             $this->add(new Zend_Acl_Resource('admin:voluntariadopdf'));
              $this->add(new Zend_Acl_Resource('admin:imagenesnoticia'));
                     $this->add(new Zend_Acl_Resource('admin:wallpapers'));
	
     
    
    $this->addRole( new Zend_Acl_Role( 'invitado' ) );    
    $this->addRole( new Zend_Acl_Role( 'usuario' ),'invitado' );   

    $this->addRole( new Zend_Acl_Role('administrador'));
    
    
    
 /*invitado*/
    $this->deny('invitado');
    $this->allow('invitado','admin:captcha');
    $this->allow('invitado','default:captcha');
    $this->allow('invitado','default:error');
    $this->allow('invitado','default:index');
    $this->allow('invitado','default:indexbo');
    $this->allow('invitado','default:socios');
    $this->allow('invitado','default:distribucion');
    $this->allow('invitado','default:elegir');
    
//    $this->allow('invitado','default:contactobo');
$this->allow('invitado','default:voluntariado');
$this->allow('invitado','default:organizacion');
$this->allow('invitado','default:contacto');
$this->allow('invitado','default:paises');
$this->allow('invitado','default:recintos');
$this->allow('invitado','default:calendario');
$this->allow('invitado','default:historia');
$this->allow('invitado','default:convocatoria');
$this->allow('invitado','default:noticias');
$this->allow('invitado','default:grupo');
$this->allow('invitado','default:proveedores');
$this->allow('invitado','default:certificaciones');
$this->allow('invitado','default:deportes');
$this->allow('invitado','default:contrataciones');


    
$this->allow('invitado','default:estatico');
$this->allow('invitado','default:imagenes');
$this->allow('invitado','default:videos');
$this->allow('invitado','default:mascotas');
$this->allow('invitado','default:mapas');
$this->allow('invitado','default:pdf');
    
    /*administrador*/
    $this->allow('administrador');
      $this->add(new Zend_Acl_Resource('administrador:administrador'));
     $this->add(new Zend_Acl_Resource('administrador:usuario'));
     $this->add(new Zend_Acl_Resource('administrador:captcha'));
     $this->add(new Zend_Acl_Resource('administrador:bannerimg'));
     $this->add(new Zend_Acl_Resource('administrador:contactodatos'));
     $this->add(new Zend_Acl_Resource('administrador:contactos'));
     $this->add(new Zend_Acl_Resource('administrador:estatico'));
     $this->add(new Zend_Acl_Resource('administrador:proveedores'));
     $this->add(new Zend_Acl_Resource('administrador:certificaciones'));
     $this->add(new Zend_Acl_Resource('administrador:rotador'));
     $this->add(new Zend_Acl_Resource('administrador:noticia'));
     $this->add(new Zend_Acl_Resource('administrador:noticiabo'));
     $this->add(new Zend_Acl_Resource('administrador:marca'));
     $this->add(new Zend_Acl_Resource('administrador:socios'));
     $this->add(new Zend_Acl_Resource('administrador:receta'));
     $this->add(new Zend_Acl_Resource('administrador:productos'));
        $this->add(new Zend_Acl_Resource('administrador:index'));
        
        
 $this->addRole( new Zend_Acl_Role('administracion'));
$this->deny('administracion');
$this->allow('administracion','admin:index');
//$this->allow('administracion','admin:pdf');
$this->allow('administracion','admin:contrataciones');
$this->allow('administracion','default:captcha');


$this->addRole( new Zend_Acl_Role('voluntario'));
$this->deny('voluntario');
$this->allow('voluntario','admin:voluntariado');
$this->allow('voluntario','admin:index');
$this->allow('voluntario','default:captcha');
$this->allow('voluntario','admin:voluntariadotipo');
$this->allow('voluntario','admin:voluntariadopreguntas');
$this->allow('voluntario','admin:voluntariadopdf');
$this->allow('voluntario','admin:voluntariadobeneficios');
  }
}