
!function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a="function"==typeof require&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}for(var i="function"==typeof require&&require,o=0;o<r.length;o++)s(r[o]);return s}({1:[function(require,module,exports){var SweetModal,helpers,templates,bind=function(fn,me){return function(){return fn.apply(me,arguments)}};helpers=require("./helpers.coffee"),templates=require("./templates.coffee"),SweetModal=function(){function SweetModal(params){this.params=params,this.close=bind(this.close,this)}return SweetModal.prototype.params={},SweetModal.prototype.$overlay=null,SweetModal.prototype.getParams=function(){return this.params},SweetModal.prototype._constructButtons=function($modal){var $button,$buttons,label,name,obj,ref;if($buttons=$(templates.buttons),"object"==typeof this.params.buttons&&helpers.objectSize(this.params.buttons)>0){ref=this.params.buttons;for(name in ref)obj=ref[name],obj=$.extend({label:void 0,action:function(){},classes:"",class:""},obj),obj.classes.length<1&&(obj.classes=obj.class),label=obj.label||""===obj.label?obj.label:name,$button=$('<a href="javascript:void(0);" class="button '+obj.classes+'">'+label+"</a>"),$button.bind("click",{buttonObject:obj,parentObject:this},function(e){var result;return e.preventDefault(),result=e.data.buttonObject.action(e.data.parentObject),void 0===result||result!==!1?e.data.parentObject.close():void 0}),$buttons.append($button);$modal.append($buttons)}return $buttons},SweetModal.prototype._constructTitle=function($overlay,$modal){var $icon,$modalTabs,$modalTabsUL,$modalTitle,$tpl,icon,key,label,ref,value;if("string"==typeof this.params.title)return""!==this.params.title?$modal.find(".sweet-modal-title h2").html(this.params.title):$modal.find(".sweet-modal-title-wrap").remove();if("object"==typeof this.params.title){$overlay.addClass("tabbed"),$modalTitle=$modal.find(".sweet-modal-title"),$modalTitle.find("h2").remove(),$modalTabs=$(templates.tabs.links),$modalTabsUL=$modalTabs.find("ul"),ref=this.params.title;for(key in ref)value=ref[key],$tpl=$(templates.prepare(templates.tabs.link,{TAB_ID:key})),label=icon=!1,"string"==typeof value?(label=value,icon=!1):(label=value.label||!1,icon=value.icon||!1),icon?($icon=$tpl.find("a .icon").html(icon),value.iconCSS&&$icon.find("img, svg").css(value.iconCSS)):$tpl.find("a .icon").remove(),label||$tpl.find("a label").remove(),$tpl.find("a label").text(label),$modalTabsUL.append($tpl);return $modalTabsUL.find("li:first-child").addClass("active"),$modalTitle.append($modalTabs)}throw"Invalid title type."},SweetModal.prototype._constructContent=function($overlay,$modal){var $modalContent,$tpl,key,m,ref,value;if("string"==typeof this.params.content){if((m=this.params.content.match(/^\S+youtu\.?be\S+(?:v=|\/v\/)(\w+)$/))&&(this.params.content='<iframe width="100%" height="400" src="https://www.youtube.com/embed/'+m[1]+'" frameborder="0" allowfullscreen></iframe>'),""!==this.params.icon)switch($overlay.addClass("sweet-modal-has-icon"),this.params.icon){case $.sweetModal.ICON_SUCCESS:this.params.content=templates.icons.success+this.params.content;break;case $.sweetModal.ICON_ERROR:this.params.content=templates.icons.error+this.params.content;break;case $.sweetModal.ICON_WARNING:this.params.content=templates.icons.warning+this.params.content}$modal.find(".sweet-modal-content").html(this.params.content)}else{$modalContent=$(templates.tabs.content),ref=this.params.content;for(key in ref)value=ref[key],$tpl=$(templates.prepare(templates.tabs.tab,{TAB_ID:key})),$tpl.append(value),$modalContent.append($tpl);$modalContent.find(".sweet-modal-tab:not(:first-child)").hide(),$modal.find(".sweet-modal-content").html($modalContent)}return $modal.addClass(this.params.classes.join(" ")),$overlay.append($modal)},SweetModal.prototype.tojQueryObject=function(){var $modal,$overlay;return this.$overlay?this.$overlay:($overlay=$(templates.overlay).addClass(this.params.theme?this.params.theme.join(" "):$.sweetModal.THEME_LIGHT.join(" ")),$modal=$(templates.modal),this.params.showCloseButton||$modal.find(".sweet-modal-close").remove(),"auto"!==this.params.width&&$modal.css({width:this.params.width,left:"50%",transform:"translateX(-50%)"}),this._constructButtons($modal),this._constructTitle($overlay,$modal),this._constructContent($overlay,$modal),this.$overlay=$overlay,$overlay)},SweetModal.prototype.open=function(){var $icon,$overlay,scope;if(scope=this,$overlay=this.tojQueryObject(),$("body").append(this.$overlay),$overlay.click(function(_this){return function(e){return void 0!==e.target.hasClass&&e.target.hasClass("sweet-modal-clickable")?void 0:_this.params.blocking?_this.bounce():_this.close()}}(this)).delay(100).queue(function(){return $(this).addClass("open"),scope.params.onOpen(scope.tojQueryObject())}),$overlay.find(".sweet-modal-box").click(function(e){return void 0!==e.target.hasClass&&e.target.hasClass("sweet-modal-clickable")?void 0:e.stopPropagation()}),$overlay.find(".sweet-modal-icon").length>0)switch($icon=$overlay.find(".sweet-modal-icon"),this.params.icon){case $.sweetModal.ICON_SUCCESS:$icon.delay(80).queue(function(){return $icon.addClass("animate"),$icon.find(".sweet-modal-tip").addClass("animateSuccessTip"),$icon.find(".sweet-modal-long").addClass("animateSuccessLong")});break;case $.sweetModal.ICON_WARNING:$icon.addClass("pulseWarning"),$icon.find(".sweet-modal-body, .sweet-modal-dot").addClass("pulseWarningIns");break;case $.sweetModal.ICON_ERROR:$icon.delay(240).queue(function(){return $icon.addClass("animateErrorIcon"),$icon.find(".sweet-modal-x-mark").addClass("animateXMark")})}return this.params.timeout&&setTimeout(function(_this){return function(){return _this.close()}}(this),this.params.timeout),this.resize(),this.appendListeners(),this},SweetModal.prototype.bounce=function(){var $overlay;return $overlay=this.tojQueryObject(),$overlay.addClass("bounce"),setTimeout(function(){return $overlay.removeClass("bounce")},300)},SweetModal.prototype.resize=function(){var $modalBox,$overlay,mobileView;return $overlay=this.tojQueryObject(),$modalBox=$overlay.find(".sweet-modal-box"),mobileView=window.matchMedia("screen and (max-width: 914px)").matches,mobileView?$modalBox.removeAttr("style"):($(window).resize(function(){return $modalBox.height()>$(window).height()?$modalBox.css({top:"0",marginTop:"96px"}):$modalBox.css({top:"50%",marginTop:-$modalBox.height()/2-6})}),$(window).trigger("resize")),this},SweetModal.prototype.appendListeners=function(){var $overlay;return $overlay=this.tojQueryObject(),$overlay.find(".sweet-modal-close-link").off("click").click(function(_this){return function(){return _this.close()}}(this)),$overlay.find(".sweet-modal-tabs-links a").off("click").click(function(e){var $innerOverlay,tabHref;return e.preventDefault(),tabHref=$(this).attr("href").replace("#",""),$innerOverlay=$(this).closest(".sweet-modal-overlay"),$innerOverlay.find(".sweet-modal-tabs-links li").removeClass("active").find("a[href='#"+tabHref+"']").closest("li").addClass("active"),$innerOverlay.find(".sweet-modal-tabs-content .sweet-modal-tab").hide().filter("[data-tab="+tabHref+"]").show()}),this},SweetModal.prototype.close=function(){var $overlay,modal;return $overlay=this.tojQueryObject(),$.sweetModal.storage.openModals=function(){var i,len,ref,results;for(ref=$.sweetModal.storage.openModals,results=[],i=0,len=ref.length;len>i;i++)modal=ref[i],modal.getParams()!==this.getParams()&&results.push(modal);return results}.call(this),$overlay.removeClass("open"),this.params.onClose(),setTimeout(function(_this){return function(){return $overlay.remove()}}(this),300),this},SweetModal}(),module.exports=SweetModal},{"./helpers.coffee":2,"./templates.coffee":4}],2:[function(require,module,exports){module.exports={isMobile:function(){return window.matchMedia("screen and (max-width: 420px)").matches},validate:function(params){var isInvalidTabs;if(isInvalidTabs="object"==typeof params.title&&!1||"object"==typeof params.content&&!1,isInvalidTabs&&params.content.length!==params.title.length)throw"Title and Content count did not match.";return!0},objectSize:function(obj){return Object.keys(obj).length}}},{}],3:[function(require,module,exports){!function($){var SweetModal,helpers,templates;return SweetModal=require("./SweetModal.class.coffee"),helpers=require("./helpers.coffee"),templates=require("./templates.coffee"),$.sweetModal=function(props,message){var callbacks,modal,params;return"string"==typeof props&&(props=void 0===message?{content:props}:{title:props,content:message}),(!props.title||props.icon&&props.title)&&(props.type=$.sweetModal.TYPE_ALERT,props.classes=props.classes||["alert"]),params=$.extend({},$.sweetModal.defaultSettings,props),params.content.length<1&&(params.content=params.message),"function"==typeof params.onDisplay&&(params.onOpen=params.onDisplay),callbacks={onOpen:params.onOpen,onClose:params.onClose},params.onOpen=function($overlay){return $.sweetModal.defaultCallbacks.onOpen(),"function"==typeof callbacks.onOpen?callbacks.onOpen($overlay):void 0},params.onClose=function(){return $.sweetModal.defaultCallbacks.onClose(),"function"==typeof callbacks.onClose?callbacks.onClose():void 0},helpers.validate(params),modal=new SweetModal(params),modal.open(),$.sweetModal.storage.openModals.push(modal),modal},$.sweetModal.confirm=function(arg1,arg2,arg3,arg4){var content,errorCallback,successCallback,title;if(title="","string"!=typeof arg1||"function"!=typeof arg2&&void 0!==arg2&&null!==arg2){if("string"!=typeof arg1||"string"!=typeof arg2||"function"!=typeof arg3&&void 0!==arg3&&null!==arg3)throw"Invalid argument configuration.";title=arg1,content=arg2,successCallback=arg3||function(){},errorCallback=arg4||function(){}}else content=arg1,successCallback=arg2||function(){},errorCallback=arg3||function(){};return $.sweetModal({title:title,content:content,buttons:{cancel:{label:$.sweetModal.defaultSettings.confirm.cancel.label,action:errorCallback,classes:$.sweetModal.defaultSettings.confirm.cancel.classes},ok:{label:$.sweetModal.defaultSettings.confirm.yes.label,action:successCallback,classes:$.sweetModal.defaultSettings.confirm.yes.classes}},classes:["alert","confirm"],showCloseButton:!1,blocking:!0})},$.sweetModal.prompt=function(title,placeholder,value,successCallback,errorCallback){var buttons,content;return null==placeholder&&(placeholder=""),null==value&&(value=""),null==successCallback&&(successCallback=null),null==errorCallback&&(errorCallback=null),content=$(templates.prepare(templates.prompt,{TYPE:"text",PLACEHOLDER:placeholder,VALUE:value})),buttons={},successCallback=successCallback||function(){},errorCallback=errorCallback||function(){},$.sweetModal({title:title,content:content.wrap("<div />").parent().html(),buttons:{cancel:{label:$.sweetModal.defaultSettings.confirm.cancel.label,action:errorCallback,classes:$.sweetModal.defaultSettings.confirm.cancel.classes},ok:{label:$.sweetModal.defaultSettings.confirm.ok.label,classes:$.sweetModal.defaultSettings.confirm.ok.classes,action:function(){return successCallback($(".sweet-modal-prompt input").val())}}},classes:["prompt"],showCloseButton:!1,blocking:!0,onOpen:function($overlay){return $overlay.find("input").focus()}})},$.sweetModal.allModalsClosed=function(){return 0===$.sweetModal.storage.openModals.length},$.sweetModal.defaultSettings={title:"",message:"",content:"",icon:"",classes:[],showCloseButton:!0,blocking:!1,timeout:null,theme:$.sweetModal.THEME_LIGHT,type:$.sweetModal.TYPE_MODAL,width:"auto",buttons:{},confirm:{yes:{label:"Yes",classes:"greenB"},ok:{label:"OK",classes:"greenB"},cancel:{label:"Cancel",classes:"redB bordered flat"}},onOpen:null,onClose:null},$.sweetModal.defaultCallbacks={onOpen:function(){return $("body").css({overflow:"hidden"}),$("#content_wrap").addClass("blurred")},onClose:function(){return $.sweetModal.allModalsClosed()?($("body").css({overflow:"auto"}),$("#content_wrap").removeClass("blurred")):void 0}},$.sweetModal.storage={openModals:[]},"function"!=typeof $.confirm&&($.confirm=$.sweetModal,$.confirm.close=$.sweetModal.closeAll),$.sweetModal.mapNativeFunctions=function(){return window.alert=function(message){return $.sweetModal(message)}},$.sweetModal.THEME_COMPONENTS={LIGHT_OVERLAY:"light-overlay",LIGHT_MODAL:"light-modal",DARK_OVERLAY:"dark-overlay",DARK_MODAL:"dark-modal"},$.sweetModal.THEME_LIGHT=[$.sweetModal.THEME_COMPONENTS.LIGHT_OVERLAY,$.sweetModal.THEME_COMPONENTS.LIGHT_MODAL],$.sweetModal.THEME_DARK=[$.sweetModal.THEME_COMPONENTS.DARK_OVERLAY,$.sweetModal.THEME_COMPONENTS.DARK_MODAL],$.sweetModal.THEME_MIXED=[$.sweetModal.THEME_COMPONENTS.DARK_OVERLAY,$.sweetModal.THEME_COMPONENTS.LIGHT_MODAL],$.sweetModal.TYPE_ALERT="alert",$.sweetModal.TYPE_MODAL="modal",$.sweetModal.ICON_SUCCESS="success",$.sweetModal.ICON_ERROR="error",$.sweetModal.ICON_WARNING="warning"}(jQuery)},{"./SweetModal.class.coffee":1,"./helpers.coffee":2,"./templates.coffee":4}],4:[function(require,module,exports){module.exports={overlay:'<div class="sweet-modal-overlay">\n</div>',modal:'<div class="sweet-modal-box">\n	<div class="sweet-modal-close"><a href="javascript:void(0);" class="sweet-modal-close-link"></a></div>\n	<div class="sweet-modal-title-wrap">\n		<div class="sweet-modal-title"><h2></h2></div>\n	</div>\n	\n	<div class="sweet-modal-content">\n	</div>\n</div>',buttons:'<div class="sweet-modal-buttons"></div>',tabs:{links:'<div class="sweet-modal-tabs-links">\n	<ul>\n	</ul>\n</div>',content:'<div class="sweet-modal-tabs-content">\n</div>',link:'<li>\n	<a href="#modal-{TAB_ID}">\n		<span class="icon"></span>\n		<label></label>\n	</a>\n</li>',tab:'<div class="sweet-modal-tab" data-tab="modal-{TAB_ID}">\n</div>'},icons:{error:'<div class="sweet-modal-icon sweet-modal-error">\n	<span class="sweet-modal-x-mark">\n		<span class="sweet-modal-line sweet-modal-left"></span>\n		<span class="sweet-modal-line sweet-modal-right"></span>\n	</span>\n</div>',warning:'<div class="sweet-modal-icon sweet-modal-warning">\n	<span class="sweet-modal-body"></span>\n	<span class="sweet-modal-dot"></span>\n</div>',info:'<div class="sweet-modal-icon sweet-modal-info"></div>',success:'<div class="sweet-modal-icon sweet-modal-success">\n	<span class="sweet-modal-line sweet-modal-tip"></span>\n	<span class="sweet-modal-line sweet-modal-long"></span>\n	<div class="sweet-modal-placeholder"></div>\n	<div class="sweet-modal-fix"></div>\n</div>'},prompt:'<div class="sweet-modal-prompt">\n	<input type="{TYPE}" placeholder="{PLACEHOLDER}" value="{VALUE}" />\n</div>',prepare:function(tpl,strings){var i,len,lookup,m,matches,replacement;for(matches=tpl.match(/\{([A-Z0-9_\-]+)\}/g)||[],i=0,len=matches.length;len>i;i++)m=matches[i],lookup=m.replace(/\{|\}/g,""),replacement=strings[lookup],void 0===replacement&&(replacement="{"+lookup+"}"),tpl=tpl.replace(new RegExp(m,"g"),replacement);return tpl}}},{}]},{},[3]);
