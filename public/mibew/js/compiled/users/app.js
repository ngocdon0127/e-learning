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
!function(e,n,t){var s=0,o=function(){s++,10==s&&(e.Utils.alert(e.Localization.trans("Network problems detected. Please refresh the page.")),s=0)},i=new n.Marionette.Application;i.addRegions({agentsRegion:"#agents-region",statusPanelRegion:"#status-panel-region",threadsRegion:"#threads-region",visitorsRegion:"#visitors-region"}),i.addInitializer(function(n){var s=e.Objects,a=e.Objects.Models,r=e.Objects.Collections;s.server=new e.Server(t.extend({interactionType:MibewAPIUsersInteraction,onTimeout:o,onTransportError:o},n.server)),a.page=new e.Models.Page(n.page),a.agent=new e.Models.Agent(n.agent),r.threads=new e.Collections.Threads,i.threadsRegion.show(new e.Views.ThreadsCollection({collection:r.threads})),n.page.showVisitors&&(r.visitors=new e.Collections.Visitors,i.visitorsRegion.show(new e.Views.VisitorsCollection({collection:r.visitors}))),a.statusPanel=new e.Models.StatusPanel,i.statusPanelRegion.show(new e.Views.StatusPanel({model:a.statusPanel})),n.page.showOnlineOperators&&(r.agents=new e.Collections.Agents,i.agentsRegion.show(new e.Views.AgentsCollection({collection:r.agents}))),s.server.callFunctionsPeriodically(function(){return[{"function":"update",arguments:{"return":{},references:{},agentId:a.agent.id}}]},function(e){})}),i.on("start",function(){e.Objects.server.runUpdater()}),e.Application=i}(Mibew,Backbone,_);