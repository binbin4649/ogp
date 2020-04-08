<?php
App::uses('BcAuthComponent',  'Controller/Component');

class OgpModelEventListener extends BcModelEventListener {
	
	public $events = array(
        'Blog.BlogPost.afterSave',
        'Blog.BlogPost.beforeSave',
        'Blog.BlogPost.beforeFind',
        'Page.afterSave',
        'Page.beforeSave',
        'Page.beforeFind'
    );
    
    public function blogBlogPostBeforeSave(CakeEvent $event) {
	    $BlogPost = $event->subject();
		$data = $BlogPost->data;
	    if(!empty($data['Ogp'])){
			$Ogp = ClassRegistry::init('Ogp.Ogp');
			$Ogp->set($data['Ogp']);
			return $Ogp->validates();
		}else{
			return true;
		}
    }
    
    public function blogBlogPostAfterSave(CakeEvent $event) {
        $BlogPost = $event->subject();
        $data = $BlogPost->data;
        
        //$blog_post_id = $BlogPost->find('first', ['conditions'=>['BlogPost.no'=>'4']]);
        // 入力があれば保存する
        if(
        	!empty($data['Ogp']['id']) ||
        	!empty($data['Ogp']['title']) ||
        	!empty($data['Ogp']['description']) ||
        	!empty($data['Ogp']['image'])
         ){
	        $data['Ogp']['blog_post_id'] = $data['BlogPost']['id'];
	        $Ogp = ClassRegistry::init('Ogp.Ogp');
	        return $Ogp->save($data['Ogp']);
        }
    }
    
    public function pageBeforeSave(CakeEvent $event) {
	    $Page = $event->subject();
		$data = $Page->data;
	    if(!empty($data['Ogp'])){
		    $Ogp = ClassRegistry::init('Ogp.Ogp');
		    $Ogp->set($data['Ogp']);
			return $Ogp->validates();
	    }else{
		    return true;
	    }
    }
    
    public function pageAfterSave(CakeEvent $event){
	    $Page = $event->subject();
	    $data = $Page->data;
	    if(
        	!empty($data['Ogp']['id']) ||
        	!empty($data['Ogp']['title']) ||
        	!empty($data['Ogp']['description']) ||
        	!empty($data['Ogp']['image'])
         ){
	        $data['Ogp']['page_id'] = $data['Page']['id'];
	        $Ogp = ClassRegistry::init('Ogp.Ogp');
	        return $Ogp->save($data['Ogp']);
        }else{
	        return true;
        }
    }
    
    public function blogBlogPostBeforeFind(CakeEvent $event) {
	    if(BcAuthComponent::user()){
		    $BlogPost = $event->subject();
	        $Plugin = ClassRegistry::init('Plugin');
	        $inOgp = $Plugin->findByName('Ogp');
	        if(!empty($inOgp) && $inOgp['Plugin']['status'] === true){
		        $BlogPost->bindModel(array('hasOne' => array(
		            'Ogp' => array(
		                'className' => 'Ogp.Ogp',
		                'foreignKey' => 'blog_post_id',
		            )
		        )), false);
	        }
	    }
    }
    
    public function pageBeforeFind(CakeEvent $event) {
        if(BcAuthComponent::user()){
	        $Page = $event->subject();
	        $Plugin = ClassRegistry::init('Plugin');
	        $inOgp = $Plugin->findByName('Ogp');
	        if(!empty($inOgp) && $inOgp['Plugin']['status'] === true){
		        $Page->bindModel(array('hasOne' => array(
		            'Ogp' => array(
		                'className' => 'Ogp.Ogp',
		                'foreignKey' => 'page_id',
		            )
		        )), false);
	        }
        }
    }
    
}