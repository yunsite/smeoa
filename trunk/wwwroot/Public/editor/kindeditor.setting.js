		var editor;
		function editor_init(){
			if (is_mobile())
			{
				settings={
					resizeType:1,	
					filterMode : true,
					uploadJson:upload_url,
					afterCreate : function() {
						editor.width="100%";
					},
					items : []
				}
			}else{
				settings={
					resizeType:1,	
					filterMode : true,
					uploadJson:upload_url,
					afterCreate : function() {
						editor.width="100%";
					}
				}
			}
		editor = new KindEditor.create("#content",settings);
		}