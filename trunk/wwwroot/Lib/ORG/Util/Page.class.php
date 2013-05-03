<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// |         lanfengye <zibin_5257@163.com>
// +----------------------------------------------------------------------

class Page {
    
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 分页URL地址
    public $url     =   '';
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    protected $config  = array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
    // 默认分页变量名
    protected $varPage;

    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='',$url=''){
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage);
        $this->nowPage      =   !empty($_POST[$this->varPage])?intval($_POST[$this->varPage]):1;
        if($this->nowPage<1){
            $this->nowPage  =   1;
        }elseif(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);

        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)){
                parse_str($this->parameter,$parameter);
            }elseif(is_array($this->parameter)){
                $parameter      =   $this->parameter;
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                $var =  !empty($_POST)?$_POST:$_GET;
                if(empty($var)){
                    $parameter  =   array();
                }else{
                    $parameter  =   $var;
                }
            }
			$html=" <form id=\"page_search\" method=\"post\">%input%%pageStr%</form>";
			$input="<input class=\"page\" type=\"hidden\" name=\"$p\" >";
			foreach($parameter as $key=>$val){
				if(is_string($val)){
					$input.="<input type=\"hidden\" name=\"$key\" value=\"$val\">";
				}elseif(is_array($val)){
					if($val[0]=="like"){
						$input.="<input type=\"hidden\" name=\"$key\" value=\"$val[1]\">";
					}else{
						$input.="<input type=\"hidden\" name=\"$key\" value=\"$val[1]\">";
					}
				}
			}
			$html=str_replace("%input%",$input,$html);  
        }
        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
			$upPage="<input type=\"button\" value=\"".$this->config['prev']."\" onclick=\"this.form.$p.value=$upRow;this.form.submit();\">";
        }else{
            $upPage     =   '';
        }

        if ($downRow <= $this->totalPages){
			$downPage="<input type=\"button\" value=\"".$this->config['next']."\" onclick=\"this.form.$p.value=$downRow;this.form.submit();\">";           
        }else{
            $downPage   =   '';
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst   =   '';
            $prePage    =   '';
        }else{
            $preRow     =   $this->nowPage-$this->rollPage;
			$prePage="<input type=\"button\" value=\"上".$this->rollPage."页\" onclick=\"this.form.$p.value=$preRow;this.form.submit();\">"; 
			$theFirst="<input type=\"button\" value=\"".$this->config['first']."\" onclick=\"this.form.$p.value=1;this.form.submit();\">";	
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage   =   '';
            $theEnd     =   '';
        }else{
            $nextRow    =   $this->nowPage+$this->rollPage;
            $theEndRow  =   $this->totalPages;
			$nextPage="<input type=\"button\" value=\"下".$this->rollPage."页\" onclick=\"this.form.$p.value=$nextRow;this.form.submit();\">"; 
			$theEnd="<input type=\"button\" value=\"".$this->config['last']."\" onclick=\"this.form.$p.value=$theEndRow;this.form.submit();\">"; 
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page       =   ($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
				$linkPage.="<input type=\"button\" value=\"$page\" onclick=\"this.form.$p.value=$page;this.form.submit();\">";                     
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
					$linkPage.="<input class='current' type=\"button\" value=\"$page\">";                     
                }
            }
        }
        $pageStr     =   str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
		$pageStr=str_replace("%pageStr%",$pageStr,$html);
        return $pageStr;
    }
}