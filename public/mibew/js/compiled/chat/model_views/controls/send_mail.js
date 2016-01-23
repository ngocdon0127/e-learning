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
!function(e,n,t){e.Views.SendMailControl=e.Views.Control.extend({template:n.templates["chat/controls/send_mail"],events:t.extend({},e.Views.Control.prototype.events,{click:"sendMail"}),sendMail:function(){var n=this.model.get("link"),t=e.Objects.Models.page;if(n){var l=e.Utils.buildWindowParams(this.model.get("windowParams")),i=t.get("style"),o="";i&&(o=(-1===n.indexOf("?")?"?":"&")+"style="+i),n=n.replace(/\&amp\;/g,"&")+o;var a=window.open(n,"ForwardMail",l);null!==a&&(a.focus(),a.opener=window)}}})}(Mibew,Handlebars,_);