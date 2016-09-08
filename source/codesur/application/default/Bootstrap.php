<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initAutoload() {
		$moduleLoader = new Zend_Application_Module_Autoloader( array(
			'namespace' =>	'', 
			'basePath' => APPLICATION_PATH . '/default'
		));
		return $moduleLoader;
	}
	
	public function _initConstante()
	{	
		define('NOMBRE_SITIO','XI Juegos Suramericanos Cochabamba 2018');
        define('LEMA_SITIO','XI Juegos Suramericanos Cochabamba 2018');			
		define('CALIDAD_IMGS',100);			
		define('DEFAULT_IDIOMA','es');
		define('DEFAULT_EMAIL','');
		
	}
	public function _initView_() 
	{		
		
        $this->bootstrap('view');
        $view = $this->getResource('view');
		//$view->setEncoding('UTF-8');
	
		$view->doctype('XHTML1_STRICT');
		$view->headTitle()->setSeparator(' - ');
		$view->headTitle(NOMBRE_SITIO);

		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
		$view->headMeta()->appendName('resource-type', 'document');
		$view->headMeta()->appendName('revisit-after', '1 days');
		$view->headMeta()->appendName('classification', 'Internet');
		$view->headMeta()->appendName('robots', 'all');
		$view->headMeta()->appendName('googlebot', 'all');
		$view->headMeta()->appendName('distribution', 'Global');
		$view->headMeta()->appendName('rating', 'General');
				

		//$view->headLink(array('rel' => 'icon','href' => '/img/favicon.png','type'=>'image/png'));
		
	}
	
	public function _initAcl() {		
		Zend_Registry::set('Zend_Acl', new Util_Acl());
		Zend_Controller_Front::getInstance()->registerPlugin( new Util_Auth() );
	}

	public function _initDb_() 
	{
		$this->bootstrap('db');
		$db = $this->getResource('db');
		Zend_Registry::set('db',$db);
	}


	public function _initEmail() {
		$transporte = new Zend_Mail_Transport_Sendmail();
		Zend_Mail::setDefaultTransport($transporte);		
	}
	
	

	public function _initTraductor()
	{
		 $locale = new Zend_Locale();

		$trans = new Zend_Translate('tmx', APPLICATION_PATH . '/../lang/validate.tmx','es');
		$trans->addTranslation( APPLICATION_PATH . '/../lang/general.tmx','es');	
		
		$locale->setLocale(DEFAULT_IDIOMA);
		$trans->setLocale($locale);		

		Zend_Registry::set('Zend_Locale', $locale);
		Zend_Registry::set('Zend_Translate',$trans);
		Zend_Controller_Router_Route::setDefaultTranslator($trans);
		
	  
	}
	
	public function _initVisita()
	{
		$sesion=new Zend_Session_Namespace('visita');		
		if(!isset($sesion->id_visita))		
			$sesion->id_visita=sha1(microtime());
		if(!isset($sesion->ip))
		{	
				$sesion->ip=$_SERVER['REMOTE_ADDR'];
				$db=Zend_Registry::get('db');
				$ultima_fila=$db->fetchRow("SELECT * FROM visita ORDER BY vis_id DESC");
				$mes=(int)date('m',strtotime($ultima_fila['vis_fecha']));				
				$anio=(int)date('Y',strtotime($ultima_fila['vis_fecha']));
				
				$mes_actual=(int)date('m');
				$anio_actual=(int)date('Y');			
				
				if($mes_actual>$mes||$anio_actual>$anio)				
				{	
					$db->insert("visita",array('vis_visitas'=>1,'vis_fecha'=>new Zend_Db_Expr('NOW()')));
					$sesion->vis_id=$db->lastInsertId();
				}
				else
				{
					$db->update("visita",array('vis_visitas'=>new Zend_Db_Expr('vis_visitas+1')),'vis_id='.$ultima_fila['vis_id']);
					$sesion->vis_id=$ultima_fila['vis_id'];
				}
				
				//$sesion->nro_visita=(int)Util_Visitas::total();
		}
	}
	
	public function _initRutas()
	{
		$front=Zend_Controller_Front::getInstance()->getRouter();


	$front->addRoute('inicio',
    		new Zend_Controller_Router_Route(':idioma',
                                                array('module' =>	'default',
                                                  'controller' => 'index',
                                                  'action'     => 'index',        									  
                                                          'idioma'=>DEFAULT_IDIOMA        									          									  
                                                ),
                                                array(	
                                                                'idioma'=>"(es|en)"        										
                                                        )));
        /**************************************************************************************/
 $front->addRoute('mas_noticias_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/mas_noticias(?:/(pagina[0-9]+))?',
        								array('module' =>'default',
        							          'controller' => 'index',
            								  'action'     => 'masnoticias',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
                                                                            'pagina'=>""
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/mas_noticias/%s"				
    										));

    $front->addRoute('mas_noticias_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/more_news(?:/(pagina[0-9]+))?',
                                                        array('module' => 'default',
                                                          'controller' => 'index',
                                                          'action'     => 'masnoticias',        									  
                                                          'idioma'=>DEFAULT_IDIOMA,
                                                                'pagina'=>""
                                                        ),
                                                        array(	
                                                                        1=>'idioma',
                                                                      2=>'pagina'        								     										
                                                                ),
                                                                "%s/more_news/%s"				
                                                                ));
        $front->addRoute('documento_voluntariado_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/documento_voluntariado/([^/]+)',
        								array('module' =>'default',
        							          'controller' => 'voluntariado',
            								  'action'     => 'documento',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
        								),
        								array(	
        										1=>'idioma',
        										2=>'pdf_alias'        								     										
        									),
        									"%s/documento_voluntariado/%s"				
    										));

    $front->addRoute('documento_voluntariado_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/document_volunteering/([^/]+)',
                                                        array('module' => 'default',
                                                          'controller' => 'voluntariado',
                                                          'action'     => 'documento',        									  
                                                          'idioma'=>DEFAULT_IDIOMA,
                                                        ),
                                                        array(	
                                                                        1=>'idioma',
                                                                       2=>'pdf_alias'        								     										
                                                                ),
                                                                "%s/document_volunteering/%s"				
                                                                ));
    
         $front->addRoute('contacto_voluntariado_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/contactos_voluntariado/([^/]+)',
        								array('module' =>	'default',
        							          'controller' => 'voluntariado',
            								  'action'     => 'contactos',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
                                                                            'enviado'=>"",
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'        								     										
        									),
        									"%s/contactos_voluntariado/%s"				
    										));

    $front->addRoute('contacto_voluntariado_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/contacts_volunteering/([^/]+)',
                                                        array('module' =>	'default',
                                                          'controller' => 'voluntariado',
                                                          'action'     => 'contactos',        									  
                                                          'idioma'=>DEFAULT_IDIOMA,
                                                                'enviado'=>"",
                                                        ),
                                                        array(	
                                                                        1=>'idioma',
                                                                      2=>'enviado'       								     										
                                                                ),
                                                                "%s/contacts_volunteering/%s"				
                                                                ));
    
    
         $front->addRoute('contrataciones_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/contrataciones/([^/]+)',
        								array('module' =>	'default',
        							          'controller' => 'contrataciones',
            								  'action'     => 'index',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
        								   'contrataciones_alias'=>'error' 
        								),
        								array(	
        										1=>'idioma',
        										2=>'contrataciones_alias'        								     										
        									),
        									"%s/contrataciones/%s"				
    										));

    $front->addRoute('contrataciones_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/recruitments/([^/]+)',
                                                        array('module' =>	'default',
                                                          'controller' => 'contrataciones',
                                                          'action'     => 'index',        									  
                                                          'idioma'=>DEFAULT_IDIOMA,
                                                          'contrataciones_alias'=>'error'
                                                        ),
                                                        array(	
                                                                        1=>'idioma',
                                                                        2=>'contrataciones_alias'        								     										
                                                                ),
                                                                "%s/recruitments/%s"				
                                                                ));
   $front->addRoute('documentos_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/documentos/([^/]+)',
        								array('module' =>	'default',
        							          'controller' => 'pdf',
            								  'action'     => 'index',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
        								   'pdf_alias'=>'error' 
        								),
        								array(	
        										1=>'idioma',
        										2=>'pdf_alias'        								     										
        									),
        									"%s/documentos/%s"				
    										));

    $front->addRoute('documentos_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/document/([^/]+)',
                                                        array('module' =>	'default',
                                                          'controller' => 'pdf',
                                                          'action'     => 'index',        									  
                                                          'idioma'=>DEFAULT_IDIOMA,
                                                          'pdf_alias'=>'error'
                                                        ),
                                                        array(	
                                                                        1=>'idioma',
                                                                        2=>'pdf_alias'        								     										
                                                                ),
                                                                "%s/document/%s"				
                                                                ));
        $front->addRoute('mascotas_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/mascotas/([^/]+)',
        								array('module' =>	'default',
        							          'controller' => 'mascotas',
            								  'action'     => 'index',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
        								   'alias'=>'error' 
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias'        								     										
        									),
        									"%s/mascotas/%s"				
    										));

    $front->addRoute('mascotas_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/pets/([^/]+)',
                                                        array('module' =>	'default',
                                                          'controller' => 'mascotas',
                                                          'action'     => 'index',        									  
                                                          'idioma'=>DEFAULT_IDIOMA,
                                                          'alias'=>'error'

                                                        ),
                                                        array(	
                                                                        1=>'idioma',
                                                                        2=>'alias'        								     										
                                                                ),
                                                                "%s/pets/%s"				
                                                                ));
       $front->addRoute('noticias_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/noticias(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        							          'controller' => 'noticias',
            								  'action'     => 'index',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
        								  'pagina'=>''
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/noticias/%s"				
    										));

    $front->addRoute('noticias_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/news_list(?:/(page[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'noticias',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/news_list/%s"				
    										));
     $front->addRoute('convocatoria_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/convocatoria/([^/]+)',
        								array('module' =>	'default',
        							          'controller' => 'convocatoria',
            								  'action'     => 'index',        									  
        							          'idioma'=>DEFAULT_IDIOMA,
        								   'alias_convocatoria'=>'error' 
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_convocatoria'        								     										
        									),
        									"%s/convocatoria/%s"				
    										));

    $front->addRoute('convocatoria_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/calls/([^/]+)',
        								array('module' =>	'default',
        								  'controller' => 'convocatoria',
            								  'action'     => 'index',        									  
        								  'idioma'=>DEFAULT_IDIOMA,
        								  'alias_convocatoria'=>'error'
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_convocatoria'        								     										
        									),
        									"%s/calls/%s"				
    										));
    	$front->addRoute('noticia_completa_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/noticia/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'index',
            								  'action'     => 'completa',        									  
        									  'idioma'=>DEFAULT_IDIOMA,        									  
        									  'alias_noticia'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_noticia'        										
        									),
        									"%s/noticia/%s"				
    										));	
    										
	$front->addRoute('noticia_completa_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/news/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'index',
            								  'action'     => 'completa',        									  
        									  'idioma'=>DEFAULT_IDIOMA,        									  
        									  'alias_noticia'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_noticia'        										
        									),
        									"%s/news/%s"				
    										));
        $front->addRoute('principal_completa_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/noticia_principal/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'index',
            								  'action'     => 'completaprincipal',        									  
        									  'idioma'=>DEFAULT_IDIOMA,        									  
        									  'alias_principal'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_principal'        										
        									),
        									"%s/noticia_principal/%s"				
    										));	
    										
	$front->addRoute('principal_completa_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/main_news/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'index',
            								  'action'     => 'completaprincipal',        									  
        									  'idioma'=>DEFAULT_IDIOMA,        									  
        									  'alias_principal'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_principal'        										
        									),
        									"%s/main_news/%s"				
    										));
        $front->addRoute('historia_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/historia/([^/]+)',
        								array('module' =>	'default',
        								  'controller' => 'historia',
            								  'action'     => 'index',        									  
        								  'idioma'=>DEFAULT_IDIOMA,        									  
        								  'alias_historia'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_historia'        										
        									),
        									"%s/historia/%s"				
    										));	
    										
	$front->addRoute('historia_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/history/([^/]+)',
        								array('module' =>	'default',
        								 'controller' => 'historia',
            								 'action'     => 'index',        									  
        								 'idioma'=>DEFAULT_IDIOMA,        									  
        								 'alias_historia'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_historia'        										
        									),
        									"%s/history/%s"				
    										));
        	$front->addRoute('recinto_completa_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/recintos_detalle/([^/]+)',
        								array('module' =>	'default',
        								  'controller' => 'recintos',
            								  'action'     => 'completa',        									  
        								  'idioma'=>DEFAULT_IDIOMA,        									  
        								  'alias_recinto'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_recinto'        										
        									),
        									"%s/recintos_detalle/%s"				
    										));	
    										
	$front->addRoute('recinto_completa_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/precincts_detail/([^/]+)',
        								array('module' =>	'default',
                                                                          'controller' => 'recintos',
            								  'action'     => 'completa',        									  
                                                                          'idioma'=>DEFAULT_IDIOMA,        									  
        								  'alias_recinto'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_recinto'        										
        									),
        									"%s/precincts_detail/%s"				
    										));
//    $front->addRoute('noticia_completa_es',
//    		new Zend_Controller_Router_Route_Regex('(es|en)/noticia/([^/]+)',
//        								array('module' =>	'default',
//        									  'controller' => 'noticias',
//            								  'action'     => 'noticia',        									  
//        									  'idioma'=>DEFAULT_IDIOMA,        									  
//        									  'alias_noticia'=>'error'       									          									  
//        								),
//        								array(	
//        										1=>'idioma',
//        										2=>'alias_noticia'        										
//        									),
//        									"%s/noticia/%s"				
//    										));	
//    										
//	$front->addRoute('noticia_completa_en',
//    		new Zend_Controller_Router_Route_Regex('(es|en)/news/([^/]+)',
//        								array('module' =>	'default',
//        									  'controller' => 'noticias',
//            								  'action'     => 'noticia',        									  
//        									  'idioma'=>DEFAULT_IDIOMA,        									  
//        									  'alias_noticia'=>'error'       									          									  
//        								),
//        								array(	
//        										1=>'idioma',
//        										2=>'alias_noticia'        										
//        									),
//        									"%s/news/%s"				
//    										));	
   /***************** Quienes somos ********************/
  	$front->addRoute('grupo_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/grupo_companex(?:/([^/]+))?',
        								array('module' =>	'default',
        									  'controller' => 'grupo',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'alias_grupo'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_grupo'        								     										
        									),
        									"%s/grupo_companex/%s"				
    										));
    $front->addRoute('grupo_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/companex_group(?:/([^/]+))?',
        								array('module' =>	'default',
        									  'controller' => 'grupo',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'alias_grupo'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_grupo'        								     										
        									),
        									"%s/companex_group/%s"				
    										));		
    										
   
	/**************** Fin quienes somos ****************/ 
    										
/***************** Certificaciones ********************/
  	$front->addRoute('certificaciones_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/certificaciones(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'certificaciones',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>'' 
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'          								     										
        									),
        									"%s/certificaciones/%s"				
    										));	

	$front->addRoute('certificaciones_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/certifications(?:/(page[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'certificaciones',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>'' 
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'          								     										
        									),
        									"%s/certifications/%s"				
    										));	
	/**************** Fin Certificaciones ****************/
    										
    $front->addRoute('proveedores_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/proveedores(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'proveedores',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/proveedores/%s"				
    										));
    										
	$front->addRoute('proveedores_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/supliers(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'proveedores',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/supliers/%s"				
    										));    										
    										
    $front->addRoute('mapa_sitio_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/mapa_del_sitio',
        								array('module' =>	'default',
        									  'controller' => 'msitio',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA      									        									          									  
        								),
        								array(	
        										1=>'idioma'      								     										
        									),
        									"%s/mapa_del_sitio"				
    										));
    										
	$front->addRoute('mapa_sitio_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/site_map',
        								array('module' =>	'default',
        									  'controller' => 'msitio',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA      									        									          									  
        								),
        								array(	
        										1=>'idioma'      								     										
        									),
        									"%s/site_map"				
    										));    										
    										
         $front->addRoute('escenarios_deportivos_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/escenarios_deportivos',
        								array('module' =>'default',
        								 'controller' => 'mapas',
                                                                         'action'     => 'mapa',        									  
        								 'idioma'=>DEFAULT_IDIOMA      									        									          									  
        								),
        								array(	
        								1=>'idioma'      								     										
        									),
        									"%s/escenarios_deportivos"				
    										));
    										
	$front->addRoute('escenarios_deportivos_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/deportive_scenary',
        								array('module' =>'default',
        							          'controller' => 'mapas',
            								  'action'     => 'mapa',        									  
                                              'idioma'=>DEFAULT_IDIOMA      									        									          									  
        								),
        								array(	
        										1=>'idioma'      								     										
        									),
        									"%s/deportive_scenary"				
    										)); 
        
        
	$front->addRoute('contacto_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/contacto(?:/(ok))?',
        								array('module' =>	'default',
        									  'controller' => 'contacto',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'       								     										
        									),
        									"%s/contacto/%s"				
    										));
    										
	$front->addRoute('contacto_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/contact(?:/(ok))?',
        								array('module' =>	'default',
        									  'controller' => 'contacto',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'       								     										
        									),
        									"%s/contact/%s"				
    										)); 
	$front->addRoute('organizacion_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/organizacion',
        								array('module' =>	'default',
        								 'controller' => 'organizacion',
            								  'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
        								 'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma'     								     										
        									),
        									"%s/organizacion"				
    										));
    										
	$front->addRoute('organizacion_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/organization',
        								array('module' =>	'default',
        								'controller' => 'organizacion',
            								  'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
        								'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma'       										     								     										
        									),
        									"%s/organization"				
    										));
        	$front->addRoute('paises_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/paises',
        								array('module' =>'default',
        								 'controller' => 'paises',
            								  'action'     => 'index',        									  
        								  'idioma'=>DEFAULT_IDIOMA,
        								  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma'     								     										
        									),
        									"%s/paises"				
    										));
    										
	$front->addRoute('paises_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/countries',
        								array('module' =>'default',
        								'controller' => 'paises',
            								'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
        								'enviado'=> ''       									          									  
        								),
        								array(	
        									1=>'idioma'       										     								     										
        									),
        									"%s/countries"				
    										));
        $front->addRoute('deportes_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/deportes',
        								array('module' =>'default',
        								 'controller' => 'deportes',
            								  'action'     => 'index',        									  
        								  'idioma'=>DEFAULT_IDIOMA,
        								),
        								array(	
        									1=>'idioma'     								     										
        									),
        									"%s/deportes"				
    										));
    										
	$front->addRoute('deportes_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/sports',
        								array('module' =>'default',
        								'controller' => 'deportes',
            								'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
          								),
        								array(	
        									1=>'idioma'       										     								     										
        									),
        									"%s/sports"				
    										));
	$front->addRoute('voluntariado_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/voluntariado(?:/(ok))?',
        								array('module' =>	'default',
        									  'controller' => 'voluntariado',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'       								     										
        									),
        									"%s/voluntariado/%s"				
    										));
    										
	$front->addRoute('voluntariado_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/volunteering(?:/(ok))?',
        								array('module' =>	'default',
        									  'controller' => 'voluntariado',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'       								     										
        									),
        									"%s/volunteering/%s"				
    										));    										
    										
    										
    										
    										
/***************** Quienes somos Bolivia********************/
	$front->addRoute('companex_bolivia',
    		new Zend_Controller_Router_Route_Regex('bolivia(?:/(es|en))?',
        								array('module' =>	'default',
        							         'controller' => 'indexbo',
            								  'action'     => 'index',        									  
        								  'idioma'=>DEFAULT_IDIOMA       									  
        									        									          									  
        								),
        								array(	
        										1=>'idioma'       								     										
        									),
        									"bolivia/%s"				
    										));
    										
  	$front->addRoute('calendario_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/calendario',
        								array('module' =>	'default',
        								'controller' => 'calendario',
            								 'action'     => 'index',        									  
        								 'idioma'=>DEFAULT_IDIOMA
                                                        ),
        								array(	
        										1=>'idioma'        										   								     										
        									),
        									"%s/calendario"				
    										));
    										
   $front->addRoute('calendario_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/calendar',
        								array('module' =>	'default',
        								  'controller' => 'calendario',
            								  'action'     => 'index',        									  
        							          'idioma'=>DEFAULT_IDIOMA
        								),
        								array(	
        									1=>'idioma'        								     										
        									),
        									"%s/calendar"				
    										)); 
    $front->addRoute('galeria_videos_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/galeria_videos(?:/(pagina[0-9]+))?',
        								array('module' =>'default',
                                                                            'controller' => 'videos',
            								    'action'     => 'index',        									  
                                                                            'idioma'=>DEFAULT_IDIOMA,
                                                                            
        								    'pagina'=>''
        								),
        								array(	
        										1=>'idioma',
                                                                                        
        										2=>'pagina'        								     										
        									),
        									"%s/galeria_videos/%s"				
    										));
    										
    $front->addRoute('galeria_videos_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/galery_videos/([^/]+)',
        								array('module' =>	'default',
                                                                        'controller' => 'videos',
            								'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
                                                                           
        								'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        									
        										2=>'pagina'          								     										
        									),
        									"%s/galery_videos/%s"				
    										));
       $front->addRoute('ver_videos_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/ver_video/([^/]+)',
        								array('module' =>'default',
                                                                            'controller' => 'videos',
            								    'action'     => 'ver',        									  
                                                                            'idioma'=>DEFAULT_IDIOMA,
                                                                            
        								    'alias_video'=>''
        								),
        								array(	
        										1=>'idioma',
                                                                                        
        										2=>'alias_video'        								     										
        									),
        									"%s/ver_video/%s"				
    										));
    										
    $front->addRoute('ver_videos_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/see_videos(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
                                                                        'controller' => 'videos',
            								'action'     => 'ver',        									  
        								'idioma'=>DEFAULT_IDIOMA,
                                                                           
        								'alias_video'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        									
        										2=>'alias_video'          								     										
        									),
        									"%s/see_video/%s"				
    										));
    
 $front->addRoute('imagenes_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/imagenes(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
                                                                          'controller' => 'imagenes',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/imagenes/%s"				
    										));
    										
    $front->addRoute('imagenes_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/images(?:/(page[0-9]+))?',
        								array('module' =>	'default',
                                                                        'controller' => 'imagenes',
            								'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
        								'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/images/%s"				
    										));
    										    
      $front->addRoute('portafolio_imagenes_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/portafolio(?:/(pagina[0-9]+))?',
        								array('module' =>'default',
                                                                          'controller' => 'imagenes',
            								  'action'     => 'portafolio',        									  
        								  'idioma'=>DEFAULT_IDIOMA,
        								  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/portafolio/%s"				
    										));
    										
    $front->addRoute('portafolio_imagenes_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/portfolio(?:/(page[0-9]+))?',
        								array('module' =>	'default',
                                                                        'controller' => 'imagenes',
            								'action'     => 'portafolio',        									  
        								'idioma'=>DEFAULT_IDIOMA,
        								'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/portfolio/%s"				
    										));
    $front->addRoute('recintos_es',
    		new Zend_Controller_Router_Route_Regex('(es|en)/recintos(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
                                                                          'controller' => 'recintos',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/recintos/%s"				
    										));
    										
    $front->addRoute('recintos_en',
    		new Zend_Controller_Router_Route_Regex('(es|en)/campuses(?:/(page[0-9]+))?',
        								array('module' =>	'default',
                                                                        'controller' => 'recintos',
            								'action'     => 'index',        									  
        								'idioma'=>DEFAULT_IDIOMA,
        								'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"%s/campuses/%s"				
    										));
    										    										
    										
     $front->addRoute('distribucion_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/distribucion',
        								array('module' =>	'default',
        									  'controller' => 'distribucion',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA
        									  
        									        									          									  
        								),
        								array(	
        										1=>'idioma'
        																     										
        									),
        									"bolivia/%s/distribucion"				
    										));
    										
	$front->addRoute('distribucion_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/distribution',
        								array('module' =>	'default',
        									  'controller' => 'distribucion',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA
        									  
        									        									          									  
        								),
        								array(	
        										1=>'idioma'
        																     										
        									),
        									"bolivia/%s/distribution"				
    										));    										
     /* ruta contactobo */   
    										    										
     $front->addRoute('contactobo_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/contactos(?:/(ok))?',
        								array('module' =>	'default',
        									  'controller' => 'contactobo',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'       								     										
        									),
        									"bolivia/%s/contactos/%s"        													
    										));
    										
    										
	 										
     $front->addRoute('contactobo_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/contacts(?:/(ok))?',
        								array('module' =>	'default',
        									  'controller' => 'contactobo',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'enviado'=> ''       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'enviado'       								     										
        									),
        									"bolivia/%s/contacts/%s"        													
    										));
        										
	/* fin ruta contactobo */    										    										
     
     $front->addRoute('porque_elegirnos_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/porque_elegirnos',
        								array('module' =>	'default',
        									  'controller' => 'elegir',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA
        									        									          									  
        								),
        								array(	
        										1=>'idioma'       								     										
        									),
        									"bolivia/%s/porque_elegirnos"				
    										));
    										
     $front->addRoute('porque_elegirnos_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/why_choose',
        								array('module' =>	'default',
        									  'controller' => 'elegir',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA
        									  
        									        									          									  
        								),
        								array(	
        										1=>'idioma'        								     										
        									),
        									"bolivia/%s/why_choose"				
    										));    										
    										
     $front->addRoute('recetas_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/recetas(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'recetas',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"bolivia/%s/recetas/%s"				
    										));  
    										
     $front->addRoute('recetas_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/recipes(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'recetas',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"bolivia/%s/recipes/%s"				
    										));      										

     $front->addRoute('receta_completa_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/receta/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'recetas',
            								  'action'     => 'receta',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'alias'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias'        								     										
        									),
        									"bolivia/%s/receta/%s"				
    										));

    $front->addRoute('receta_completa_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/recipe/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'recetas',
            								  'action'     => 'receta',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'alias'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias'        								     										
        									),
        									"bolivia/%s/recipe/%s"				
    										));    										
    /*										    										

     $front->addRoute('productos_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/productos',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,       								
        									        									          									  
        								),
        								array(	
        										1=>'idioma'       								     										
        									),
        									"bolivia/%s/productos"				
    										));
    $front->addRoute('productos_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/products',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,       								
        									        									          									  
        								),
        								array(	
        										1=>'idioma'       								     										
        									),
        									"bolivia/%s/products"				
    										));
    					*/
    										
    $front->addRoute('categoria_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/productos/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'categoria',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'categoria'=>''      									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'categoria'        								     										
        									),
        									"bolivia/%s/productos/%s"				
    										));
     										
    $front->addRoute('categoria_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/products/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'categoria',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'categoria'=>''								          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'categoria'    								     										
        									),
        									"bolivia/%s/products/%s"				
    										));
    										
    										
    										
$front->addRoute('marca_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/productos/([^/]+)/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'marca',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'categoria'=>'',
        									  'marca'=>''	
        									  
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'categoria',
        										3=>'marca'        								     										
        									),
        									"bolivia/%s/productos/%s/%s"				
    										));
     										
    $front->addRoute('marca_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/products/([^/]+)/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'marca',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'categoria'=>'',
        								      'marca'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'categoria',
        										3=>'marca'        								     										
        									),
        									"bolivia/%s/products/%s/%s"				
    										));
    										
$front->addRoute('presentacion_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/productos/([^/]+)/([^/]+)/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'presentacion',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'categoria'=>'',
        									  'marca'=>'',
        									  'presentacion'=>''        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'categoria',
        										3=>'marca',
        										4=>'presentacion'      								     										
        									),
        									"bolivia/%s/productos/%s/%s/%s"				
    										));
     										
    $front->addRoute('presentacion_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/products/([^/]+)/([^/]+)/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'productos',
            								  'action'     => 'presentacion',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'categoria'=>'',
        									  'marca'=>'',
        									  'presentacion'=>''        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'categoria',
        										3=>'marca',
        										4=>'presentacion'      								     										
        									),
        									"bolivia/%s/products/%s/%s/%s"				
    										));
   
	/***************** Quienes somos Bolivia********************/    										
    										

    $front->addRoute('noticiasbo_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/noticias(?:/(pagina[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'noticiasbo',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"bolivia/%s/noticias/%s"				
    										));

    $front->addRoute('noticiasbo_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/news_list(?:/(page[0-9]+))?',
        								array('module' =>	'default',
        									  'controller' => 'noticiasbo',
            								  'action'     => 'index',        									  
        									  'idioma'=>DEFAULT_IDIOMA,
        									  'pagina'=>''
        									        									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'pagina'        								     										
        									),
        									"bolivia/%s/news_list/%s"				
    										));
    										
    $front->addRoute('noticiabo_completa_es',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/noticia/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'noticiasbo',
            								  'action'     => 'noticia',        									  
        									  'idioma'=>DEFAULT_IDIOMA,        									  
        									  'alias_noticia'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_noticia'        										
        									),
        									"bolivia/%s/noticia/%s"				
    										));	
    										
	$front->addRoute('noticiabo_completa_en',
    		new Zend_Controller_Router_Route_Regex('bolivia/(es|en)/news/([^/]+)',
        								array('module' =>	'default',
        									  'controller' => 'noticiasbo',
            								  'action'     => 'noticia',        									  
        									  'idioma'=>DEFAULT_IDIOMA,        									  
        									  'alias_noticia'=>'error'       									          									  
        								),
        								array(	
        										1=>'idioma',
        										2=>'alias_noticia'        										
        									),
        									"bolivia/%s/news/%s"				
    										));	


	}

	 
}