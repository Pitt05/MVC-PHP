<?php

/** @todo sécuriser l'administration avec une connexion user */
class AdminArticleController extends Controller{

	public function index(){
		$articles = ArticleModel::getAll();
		$this->set(array('articles'=>$articles));
		$this->render('index');
	}

	public function createedit(){
		//si on a un id en GET, on charge l'article, sinon on charge un article vide pour la création
		$id = isset($_GET['id'])?$_GET['id']:null;
		$article = new ArticleModel($id);
		$activeUers = UserModel::getAll(true);

		$this->set(array('article'=>$article));
		$this->set(array('users'=>$activeUers));
		$this->render('createedit');
	}

	public function postprocess(){
		//on vérifie si on a bien des donnee POST envoyée
		if(count($_POST)){
			$id = isset($_GET['id'])?$_GET['id']:null;
			$article = new ArticleModel($id);
			$article->titre = $_POST['titre'];
			$article->contenu = $_POST['contenu'];
			$article->id_user = $_POST['auteur'];
			$article->datetime = date('Y-m-d H:i:s');
			$article->save();
		}
		header('Location: ' . WEBROOT . 'adminarticle/index');
	}

	public function delete(){
		$article = new ArticleModel($_GET['id']);
		$article->delete();
		header('Location: ' . WEBROOT . 'adminarticle/index');
	}
}