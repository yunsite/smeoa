<?php
class DocViewModel extends ViewModel {
	public $viewFields=array(
		'Doc'=>array('id','doc_no','type','name','folder','add_file','user_id','user_name','is_del','create_time','update_time'),
		'Folder'=>array('name'=>'folder_name','_on'=>'Doc.folder=Folder.id')
		);
}
?>