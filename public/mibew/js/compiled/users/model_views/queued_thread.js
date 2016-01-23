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
!function(e,t){e.Views.QueuedThread=e.Views.CompositeBase.extend({template:t.templates["users/queued_thread"],childView:e.Views.Control,childViewContainer:".thread-controls",className:"thread",modelEvents:{change:"render"},events:{"click .open-dialog":"openDialog","click .view-control":"viewDialog","click .track-control":"showTrack","click .ban-control":"showBan","click .geo-link":"showGeoInfo","click .first-message a":"showFirstMessage"},initialize:function(){this.lastStyles=[]},serializeData:function(){var t=this.model,i=e.Objects.Models.page,s=t.toJSON();return s.stateDesc=this.stateToDesc(t.get("state")),s.chatting=t.get("state")==t.STATE_CHATTING,s.tracked=i.get("showVisitors"),s.firstMessage&&(s.firstMessagePreview=s.firstMessage.length>30?s.firstMessage.substring(0,30)+"...":s.firstMessage),s},stateToDesc:function(t){var i=e.Localization;return t==this.model.STATE_QUEUE?i.trans("In queue"):t==this.model.STATE_WAITING?i.trans("Waiting for operator"):t==this.model.STATE_CHATTING?i.trans("In chat"):t==this.model.STATE_CLOSED?i.trans("Closed"):t==this.model.STATE_LOADING?i.trans("Loading"):""},showGeoInfo:function(){var t=this.model.get("userIp");if(t){var i=e.Objects.Models.page,s=i.get("geoLink").replace("{ip}",t);e.Popup.open(s,"ip"+t,i.get("geoWindowParams"))}},openDialog:function(){var e=this.model;if(e.get("canOpen")||e.get("canView")){var t=!e.get("canOpen");this.showDialogWindow(t)}},viewDialog:function(){this.showDialogWindow(!0)},showDialogWindow:function(t){var i=this.model,s=i.id,a=e.Objects.Models.page;e.Popup.open(a.get("agentLink")+"/"+s+(t?"?viewonly=true":""),"ImCenter"+s,e.Utils.buildWindowParams(a.get("chatWindowParams")))},showTrack:function(){var t=this.model.id,i=e.Objects.Models.page;e.Popup.open(i.get("trackedLink")+"?thread="+t,"ImTracked"+t,e.Utils.buildWindowParams(i.get("trackedUserWindowParams")))},showBan:function(){var t=this.model,i=t.get("ban"),s=e.Objects.Models.page;e.Popup.open(s.get("banLink")+"/"+(i!==!1?i.id+"/edit":"add?thread="+t.id),"ImBan"+i.id,e.Utils.buildWindowParams(s.get("banWindowParams")))},showFirstMessage:function(){var t=this.model.get("firstMessage");t&&e.Utils.alert(t)}})}(Mibew,Handlebars);