/*!
 * This file is a part of Mibew Messenger.
 *
 * Copyright 2005-2015 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
!function(t,a,e,i,o){t.Utils={},t.Utils.toUpperCaseFirst=function(t){return"string"!=typeof t?!1:""===t?t:t.substring(0,1).toUpperCase()+t.substring(1)},t.Utils.toDashFormat=function(t){if("string"!=typeof t)return!1;var a=t.match(/((?:[A-Z]?[a-z0-9]+)|(?:[A-Z][a-z0-9]*))/g);if(!a)return"";for(var e=0;e<a.length;e++)a[e]=a[e].toLowerCase();return a.join("-")},t.Utils.checkEmail=function(t){if(!t)return!1;var a=t.split("@");if(a.length<2)return!1;var e=a.pop(),i=a.join("@");return o.isFQDN(e)?/^(([a-zA-Z0-9!#$%&'*+\-/=?\^_`{|}~]+(\.[a-zA-Z0-9!#$%&'*+\-/=?\^_`{|}~]+)*)|(\".+\"))$/.test(i):!1},t.Utils.playSound=function(t){var e=a('audio[data-file="'+t+'"]');if(e.length>0)e.get(0).play();else{var i=a("<audio>",{autoplay:!0,style:"display: none"}).append('<source src="'+t+'.wav" type="audio/x-wav" /><source src="'+t+'.mp3" type="audio/mpeg" codecs="mp3" /><embed src="'+t+'.wav" type="audio/x-wav" hidden="true" autostart="true" loop="false" />');a("body").append(i),a.isFunction(i.get(0).play)&&i.attr("data-file",t)}},t.Utils.buildWindowParams=function(t){var a=e.defaults({},t,{toolbar:!1,scrollbars:!1,location:!1,status:!0,menubar:!1,width:640,heght:480,resizable:!0});return["toolbar="+(a.toolbar?"1":"0"),"scrollbars="+(a.scrollbars?"1":"0"),"location="+(a.location?"1":"0"),"status="+(a.status?"1":"0"),"menubar="+(a.menubar?"1":"0"),"width="+a.width,"height="+a.height,"resizable="+(a.resizable?"1":"0")].join(",")};var r=e.once(function(){i.defaultOptions.className||(i.defaultOptions.className="vex-theme-default"),i.dialog.buttons.YES.text=t.Localization.trans("OK"),i.dialog.buttons.NO.text=t.Localization.trans("Cancel")}),n=function(){return i.getAllVexes().length>0};t.Utils.alert=function(t){r(),n()||i.dialog.alert({message:t})},t.Utils.confirm=function(t,a){r(),i.dialog.confirm({message:t,callback:a})},t.Utils.prompt=function(t,a){r(),i.dialog.prompt({message:t,callback:a})}}(Mibew,jQuery,_,vex,validator);