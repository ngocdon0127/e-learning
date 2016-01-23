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
!function(e,t){e.Regions={},e.Popup={},e.Popup.open=function(e,t,i){t=t.replace(/[^A-z0-9_]+/g,"");var s=window.open(e,t,i);s.focus(),s.opener=window},e.Utils.updateTimers=function(e,i){e.find(i).each(function(){var e=t(this).data("timestamp");if(e){var i=Math.round((new Date).getTime()/1e3)-e,s=i%60,n=Math.floor(i/60)%60,o=Math.floor(i/3600),a=[];o>0&&a.push(o),a.push(10>n?"0"+n:n),a.push(10>s?"0"+s:s),t(this).html(a.join(":"))}})}}(Mibew,jQuery),/*!
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
MibewAPIUsersInteraction=function(){this.mandatoryArguments=function(){return{"*":{agentId:null,"return":{},references:{}},result:{errorCode:0}}},this.getReservedFunctionsNames=function(){return["result"]}},MibewAPIUsersInteraction.prototype=new MibewAPIInteraction,/*!
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
function(e,t){e.Models.Agent=e.Models.User.extend({defaults:t.extend({},e.Models.User.prototype.defaults,{id:null,isAgent:!0,away:!1}),away:function(){this.setAvailability(!1)},available:function(){this.setAvailability(!0)},setAvailability:function(t){var i=t?"available":"away",s=this;e.Objects.server.callFunctions([{"function":i,arguments:{agentId:this.id,references:{},"return":{}}}],function(e){0==e.errorCode&&s.set({away:!t})},!0)}})}(Mibew,_),/*!
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
function(e,t){var i=[],s=e.Models.QueuedThread=e.Models.Thread.extend({defaults:t.extend({},e.Models.Thread.prototype.defaults,{controls:null,userName:"",userIp:"",remote:"",userAgent:"",agentName:"",canOpen:!1,canView:!1,canBan:!1,ban:!1,totalTime:0,waitingTime:0,firstMessage:null}),initialize:function(){for(var t=this,i=[],n=s.getControls(),o=0,a=n.length;a>o;o++)i.push(new n[o]({thread:t}));this.set({controls:new e.Collections.Controls(i)})}},{addControl:function(e){i.push(e)},getControls:function(){return i}})}(Mibew,_),/*!
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
function(e){e.Models.StatusPanel=e.Models.Base.extend({defaults:{message:""},setStatus:function(e){this.set({message:e})},changeAgentStatus:function(){var t=e.Objects.Models.agent;t.get("away")?t.available():t.away()}})}(Mibew),/*!
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
function(e,t){var i=[],s=e.Models.Visitor=e.Models.User.extend({defaults:t.extend({},e.Models.User.prototype.defaults,{controls:null,userName:"",userIp:"",remote:"",userAgent:"",firstTime:0,lastTime:0,invitations:0,chats:0,invitationInfo:!1}),initialize:function(){for(var t=this,i=[],n=s.getControls(),o=0,a=n.length;a>o;o++)i.push(new n[o]({visitor:t}));this.set({controls:new e.Collections.Controls(i)})}},{addControl:function(e){i.push(e)},getControls:function(){return i}})}(Mibew,_),/*!
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
function(e,t,i){e.Collections.Agents=t.Collection.extend({model:e.Models.Agent,comparator:function(e){return e.get("name")},initialize:function(){var t=e.Objects.Models.agent;e.Objects.server.callFunctionsPeriodically(function(){return[{"function":"updateOperators",arguments:{agentId:t.id,"return":{operators:"operators"},references:{}}}]},i.bind(this.updateOperators,this))},updateOperators:function(e){this.set(e.operators)}})}(Mibew,Backbone,_),/*!
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
function(e,t,i){e.Collections.Threads=t.Collection.extend({model:e.Models.QueuedThread,initialize:function(){this.revision=0;var t=this,s=e.Objects.Models.agent;e.Objects.server.callFunctionsPeriodically(function(){return[{"function":"currentTime",arguments:{agentId:s.id,"return":{time:"currentTime"},references:{}}},{"function":"updateThreads",arguments:{agentId:s.id,revision:t.revision,"return":{threads:"threads",lastRevision:"lastRevision"},references:{}}}]},i.bind(this.updateThreads,this))},comparator:function(e){var t={field:e.get("waitingTime").toString()};return this.trigger("sort:field",e,t),t.field},updateThreads:function(t){if(0==t.errorCode){if(t.threads.length>0){var i;i=t.currentTime?Math.round((new Date).getTime()/1e3)-t.currentTime:0;for(var s=0,n=t.threads.length;n>s;s++)t.threads[s].totalTime=parseInt(t.threads[s].totalTime)+i,t.threads[s].waitingTime=parseInt(t.threads[s].waitingTime)+i;this.trigger("before:update:threads",t.threads);var o=e.Models.Thread.prototype.STATE_CLOSED,a=e.Models.Thread.prototype.STATE_LEFT,r=[];this.set(t.threads,{remove:!1,sort:!1}),r=this.filter(function(e){return e.get("state")==o||e.get("state")==a}),r.length>0&&this.remove(r),this.sort(),this.trigger("after:update:threads")}this.revision=t.lastRevision}}})}(Mibew,Backbone,_),/*!
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
function(e,t,i){e.Collections.Visitors=t.Collection.extend({model:e.Models.Visitor,initialize:function(){var t=e.Objects.Models.agent;e.Objects.server.callFunctionsPeriodically(function(){return[{"function":"currentTime",arguments:{agentId:t.id,"return":{time:"currentTime"},references:{}}},{"function":"updateVisitors",arguments:{agentId:t.id,"return":{visitors:"visitors"},references:{}}}]},i.bind(this.updateVisitors,this))},comparator:function(e){var t={field:e.get("firstTime").toString()};return this.trigger("sort:field",e,t),t.field},updateVisitors:function(e){if(0==e.errorCode){var t;t=e.currentTime?Math.round((new Date).getTime()/1e3)-e.currentTime:0;for(var i=0,s=e.visitors.length;s>i;i++)e.visitors[i].lastTime=parseInt(e.visitors[i].lastTime)+t,e.visitors[i].firstTime=parseInt(e.visitors[i].firstTime)+t;this.trigger("before:update:visitors",e.visitors),this.reset(e.visitors),this.trigger("after:update:visitors")}}})}(Mibew,Backbone,_),/*!
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
function(e,t,i){e.Views.Agent=t.Marionette.ItemView.extend({template:i.templates["users/agent"],tagName:"span",className:"agent",modelEvents:{change:"render"},initialize:function(){this.isModelFirst=!1,this.isModelLast=!1},serializeData:function(){var e=this.model.toJSON();return e.isFirst=this.isModelFirst,e.isLast=this.isModelLast,e}})}(Mibew,Backbone,Handlebars),/*!
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
function(e,t,i){e.Views.NoThreads=t.Marionette.ItemView.extend({template:i.templates["users/no_threads"],initialize:function(e){this.tagName=e.tagName}})}(Mibew,Backbone,Handlebars),/*!
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
function(e,t,i){e.Views.NoVisitors=t.Marionette.ItemView.extend({template:i.templates["users/no_visitors"],initialize:function(e){this.tagName=e.tagName}})}(Mibew,Backbone,Handlebars),/*!
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
function(e,t){e.Views.QueuedThread=e.Views.CompositeBase.extend({template:t.templates["users/queued_thread"],childView:e.Views.Control,childViewContainer:".thread-controls",className:"thread",modelEvents:{change:"render"},events:{"click .open-dialog":"openDialog","click .view-control":"viewDialog","click .track-control":"showTrack","click .ban-control":"showBan","click .geo-link":"showGeoInfo","click .first-message a":"showFirstMessage"},initialize:function(){this.lastStyles=[]},serializeData:function(){var t=this.model,i=e.Objects.Models.page,s=t.toJSON();return s.stateDesc=this.stateToDesc(t.get("state")),s.chatting=t.get("state")==t.STATE_CHATTING,s.tracked=i.get("showVisitors"),s.firstMessage&&(s.firstMessagePreview=s.firstMessage.length>30?s.firstMessage.substring(0,30)+"...":s.firstMessage),s},stateToDesc:function(t){var i=e.Localization;return t==this.model.STATE_QUEUE?i.trans("In queue"):t==this.model.STATE_WAITING?i.trans("Waiting for operator"):t==this.model.STATE_CHATTING?i.trans("In chat"):t==this.model.STATE_CLOSED?i.trans("Closed"):t==this.model.STATE_LOADING?i.trans("Loading"):""},showGeoInfo:function(){var t=this.model.get("userIp");if(t){var i=e.Objects.Models.page,s=i.get("geoLink").replace("{ip}",t);e.Popup.open(s,"ip"+t,i.get("geoWindowParams"))}},openDialog:function(){var e=this.model;if(e.get("canOpen")||e.get("canView")){var t=!e.get("canOpen");this.showDialogWindow(t)}},viewDialog:function(){this.showDialogWindow(!0)},showDialogWindow:function(t){var i=this.model,s=i.id,n=e.Objects.Models.page;e.Popup.open(n.get("agentLink")+"/"+s+(t?"?viewonly=true":""),"ImCenter"+s,e.Utils.buildWindowParams(n.get("chatWindowParams")))},showTrack:function(){var t=this.model.id,i=e.Objects.Models.page;e.Popup.open(i.get("trackedLink")+"?thread="+t,"ImTracked"+t,e.Utils.buildWindowParams(i.get("trackedUserWindowParams")))},showBan:function(){var t=this.model,i=t.get("ban"),s=e.Objects.Models.page;e.Popup.open(s.get("banLink")+"/"+(i!==!1?i.id+"/edit":"add?thread="+t.id),"ImBan"+i.id,e.Utils.buildWindowParams(s.get("banWindowParams")))},showFirstMessage:function(){var t=this.model.get("firstMessage");t&&e.Utils.alert(t)}})}(Mibew,Handlebars),/*!
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
function(e,t,i){e.Views.StatusPanel=t.Marionette.ItemView.extend({template:i.templates["users/status_panel"],modelEvents:{change:"render"},ui:{changeStatus:"#change-status"},events:{"click #change-status":"changeAgentStatus"},initialize:function(){e.Objects.Models.agent.on("change",this.render,this)},changeAgentStatus:function(){this.model.changeAgentStatus()},serializeData:function(){var t=this.model.toJSON();return t.agent=e.Objects.Models.agent.toJSON(),t}})}(Mibew,Backbone,Handlebars),/*!
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
function(e,t){e.Views.Visitor=e.Views.CompositeBase.extend({template:t.templates["users/visitor"],childView:e.Views.Control,childViewContainer:".visitor-controls",className:"visitor",modelEvents:{change:"render"},events:{"click .invite-link":"inviteUser","click .geo-link":"showGeoInfo","click .track-control":"showTrack"},inviteUser:function(){if(!this.model.get("invitationInfo")){var t=this.model.id,i=e.Objects.Models.page;e.Popup.open(i.get("inviteLink")+"?visitor="+t,"ImCenter"+t,e.Utils.buildWindowParams(i.get("inviteWindowParams")))}},showTrack:function(){var t=this.model.id,i=e.Objects.Models.page;e.Popup.open(i.get("trackedLink")+"?visitor="+t,"ImTracked"+t,e.Utils.buildWindowParams(i.get("trackedVisitorWindowParams")))},showGeoInfo:function(){var t=this.model.get("userIp");if(t){var i=e.Objects.Models.page,s=i.get("geoLink").replace("{ip}",t);e.Popup.open(s,"ip"+t,i.get("geoWindowParams"))}}})}(Mibew,Handlebars),/*!
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
function(e){e.Views.AgentsCollection=e.Views.CollectionBase.extend({className:"agents-collection",collectionEvents:{"sort add remove reset":"render"},getChildView:function(t){return e.Views.Agent},initialize:function(){this.on("childview:before:render",this.updateIndexes,this)},updateIndexes:function(e){var t=this.collection,i=e.model;i&&(e.isModelFirst=0==t.indexOf(i),e.isModelLast=t.indexOf(i)==t.length-1)}})}(Mibew),/*!
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
function(e,t,i){e.Views.ThreadsCollection=e.Views.CompositeBase.extend({template:t.templates["users/threads_collection"],childViewContainer:"#threads-container",className:"threads-collection",collectionEvents:{sort:"render","sort:field":"createSortField",add:"threadAdded"},getChildView:function(t){return e.Views.QueuedThread},getEmptyView:function(){return e.Views.NoThreads},childViewOptions:function(t){var i=e.Objects.Models.page;return{tagName:i.get("threadTag"),collection:t.get("controls")}},initialize:function(){window.setInterval(i.bind(this.updateTimers,this),2e3),this.on("childview:before:render",this.updateStyles,this),this.on("render:collection",this.updateTimers,this)},updateStyles:function(e){var t=this.collection,i=e.model,s=this;if(i.id){var n=this.getQueueCode(i),o=!1,a=!1,r=t.filter(function(e){return s.getQueueCode(e)==n});if(r.length>0&&(a=r[0].id==i.id,o=r[r.length-1].id==i.id),e.lastStyles.length>0){for(var l=0,d=e.lastStyles.length;d>l;l++)e.$el.removeClass(e.lastStyles[l]);e.lastStyles=[]}var c=(n!=this.QUEUE_BAN?"in-":"")+this.queueCodeToString(n);e.lastStyles.push(c),a&&e.lastStyles.push(c+"-first"),o&&e.lastStyles.push(c+"-last");for(var l=0,d=e.lastStyles.length;d>l;l++)e.$el.addClass(e.lastStyles[l])}},updateTimers:function(){e.Utils.updateTimers(this.$el,".timesince")},createSortField:function(e,t){var i=this.getQueueCode(e)||"Z";t.field=i.toString()+"_"+e.get("waitingTime").toString()},threadAdded:function(t){var i=this.getQueueCode(t);if(i===this.QUEUE_WAITING||i===this.QUEUE_PRIO){var s=e.Objects.Models.page.get("mibewBasePath");"undefined"!=typeof s&&(s+="/sounds/new_user",e.Utils.playSound(s)),e.Objects.Models.page.get("showPopup")&&this.once("render",function(){e.Utils.alert(e.Localization.trans("A new visitor is waiting for an answer."))})}},getQueueCode:function(e){var t=e.get("state");return 0!=e.get("ban")&&t!=e.STATE_CHATTING?this.QUEUE_BAN:t==e.STATE_QUEUE||t==e.STATE_LOADING?this.QUEUE_WAITING:t==e.STATE_CLOSED||t==e.STATE_LEFT?this.QUEUE_CLOSED:t==e.STATE_WAITING?this.QUEUE_PRIO:t==e.STATE_CHATTING?this.QUEUE_CHATTING:!1},queueCodeToString:function(e){return e==this.QUEUE_PRIO?"priority-queue":e==this.QUEUE_WAITING?"waiting":e==this.QUEUE_CHATTING?"chat":e==this.QUEUE_BAN?"banned":e==this.QUEUE_CLOSED?"closed":""},QUEUE_PRIO:1,QUEUE_WAITING:2,QUEUE_CHATTING:3,QUEUE_BAN:4,QUEUE_CLOSED:5})}(Mibew,Handlebars,_),/*!
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
function(e,t,i){e.Views.VisitorsCollection=e.Views.CompositeBase.extend({template:t.templates["users/visitors_collection"],childViewContainer:"#visitors-container",className:"visitors-collection",collectionEvents:{sort:"render"},getChildView:function(t){return e.Views.Visitor},getEmptyView:function(){return e.Views.NoVisitors},childViewOptions:function(t){var i=e.Objects.Models.page;return{tagName:i.get("visitorTag"),collection:t.get("controls")}},initialize:function(){window.setInterval(i.bind(this.updateTimers,this),2e3),this.on("render:collection",this.updateTimers,this)},updateTimers:function(){e.Utils.updateTimers(this.$el,".timesince")}})}(Mibew,Handlebars,_),/*!
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
function(e,t,i){var s=0,n=function(){s++,10==s&&(e.Utils.alert(e.Localization.trans("Network problems detected. Please refresh the page.")),s=0)},o=new t.Marionette.Application;o.addRegions({agentsRegion:"#agents-region",statusPanelRegion:"#status-panel-region",threadsRegion:"#threads-region",visitorsRegion:"#visitors-region"}),o.addInitializer(function(t){var s=e.Objects,a=e.Objects.Models,r=e.Objects.Collections;s.server=new e.Server(i.extend({interactionType:MibewAPIUsersInteraction,onTimeout:n,onTransportError:n},t.server)),a.page=new e.Models.Page(t.page),a.agent=new e.Models.Agent(t.agent),r.threads=new e.Collections.Threads,o.threadsRegion.show(new e.Views.ThreadsCollection({collection:r.threads})),t.page.showVisitors&&(r.visitors=new e.Collections.Visitors,o.visitorsRegion.show(new e.Views.VisitorsCollection({collection:r.visitors}))),a.statusPanel=new e.Models.StatusPanel,o.statusPanelRegion.show(new e.Views.StatusPanel({model:a.statusPanel})),t.page.showOnlineOperators&&(r.agents=new e.Collections.Agents,o.agentsRegion.show(new e.Views.AgentsCollection({collection:r.agents}))),s.server.callFunctionsPeriodically(function(){return[{"function":"update",arguments:{"return":{},references:{},agentId:a.agent.id}}]},function(e){})}),o.on("start",function(){e.Objects.server.runUpdater()}),e.Application=o}(Mibew,Backbone,_);