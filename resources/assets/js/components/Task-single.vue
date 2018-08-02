<template>


    <div class="single-view">
        <div>{{errors.fname?errors.fname[0]:''}}</div>
        <div class=" col-sm-8 col-xs-12">
            <div class="box clearfix" style="background-color: #69437b;">
                
                <div class="tabs is-centered">
                    <ul>
                        <li class="is-active">
                            <h4 class="">
                                <a href="#" class="pointer-default">
                                    {{ task.title }}
                                </a>
                            </h4>
                        </li>
                    </ul>
                </div>
                
                <div class="light-text">
                    <p class="description-title">TASK DESCRIPTION</p>
                    
                    <div class="task-description" v-html="task.body"></div>
                    <div style="margin-bottom: 10px;"></div>
                    <div class="form-group clearfix" style="margin-top: 20px;">
                        <div class="form-group">
                            <div class="input-group check-box" v-for="row in rows" v-bind:class="{ checked: row.status }">
                                <span class="input-group-addon v-select-2 vertical-top" >
                                    <label data-type="checkbox"></label>
                                </span>
                                <textarea-autosize placeholder="Type something here..." ref="someName" rows="1" class="form-control v-select-2" v-model="row.body" :min-height="30" :max-height="350" readonly></textarea-autosize>
                            </div><!-- /input-group -->
                        </div>
                    </div>
                    <div style="margin-bottom: 10px;"></div>
                    <!-- <p class="description-timeline">CREATED AT: <span class="text-color">{{ task.created_at }}</span> &nbsp; <span class="hidden-xs">&nbsp;&nbsp;|&nbsp;&nbsp;</span> &nbsp; UPDATES ON: <span class="text-color">{{ task.updated_at }}</span></p> -->
                </div>

                <div class="description-footer">
                    <router-link to="/" class="button is-secendary">Back</router-link>
                    <router-link :to="{name: 'editTask', params: {id: task.id}}" class="button is-primary">
                        Edit Task
                    </router-link>

                    <div class="card-header pull-right">
                        <a href="#" class="card-header-icon" aria-label="more options" title="ReStart and Show this ToDo" 
                            v-if="!task.publish" 
                                v-on:click.prevent="publishTask(task.id)">
                            <span class="icon"><i class="fa " :class="{'fa-eye': !task.publish, check: !task.publish, 'fa-eye-slash': task.publish}" aria-hidden="true"></i></span>
                        </a>
                        <a href="#" class="card-header-icon" aria-label="more options" title="Finish and hide this ToDo" 
                            v-else 
                                v-on:click.prevent="publishTask(task.id)">
                            <span class="icon"><i class="fa " :class="{'fa-eye': !task.publish, check: !task.publish, 'fa-eye-slash': task.publish}" aria-hidden="true"></i></span>
                        </a>
                        <a class="card-header-icon" title="Delete ToDo" v-on:click.prevent="deleteTask(task.id)">
                            <span class="icon">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div class=" col-sm-4 col-xs-12">
            <div class="box clearfix" style="background-color: #69437b;">
                
                <div class="tabs is-centered">
                    <ul>
                        <li class="">
                            <h4 class="">
                                <a href="#" class="pointer-default">
                                    Task Info
                                </a>
                            </h4>
                        </li>
                    </ul>
                </div>
                
                <div class="light-text">
                    <p class="description-title">Share User:</p>
                    <div class="invite_user_list">
                        <div class="btn each-user" type="button">
                          {{ userDetails.name }} <span class="badge fa fa-user"></span>
                        </div>

                        <div class="btn each-user" type="button" v-for="invite_list in invite_lists" >
                          {{ invite_list.name }} <span class="badge fa fa-times" @click="deleteInvite(invite_list.id, task.id)"></span>
                        </div>
                    </div>
                    <p>
                        <form class="clearfix">
                            <input type="hidden" v-model="inviteInput.id">
                            <div class="form-group">
                                <div id="example">
                                    <!-- <label>Vue Select</label> -->
                                    <!-- <v-select multiple v-model="users.id" :options="users.id" ></v-select> -->
                                    <input class="form-control v-select" type="email" placeholder="Invite..."  v-model="inviteInput.email">
                                </div>
                            </div>
                            <div class="form-group">    
                                <a class="button is-primary pull-right" @click="inviteUser(task.id)">Send Invite</a>
                            </div>
                        </form>
                    </p>
                    <hr class="hr-soft">   
                    <p class="description-timeline">
                        STATUS: 
                        <span class="block">
                            <span class="color-box" style="width: 50px;height: 8px;display: inline-block;" v-bind:style="{ 'background-color': task.color }"></span>
                            <span class="capitalize" v-bind:style="{ 'color': task.color }"> {{ task.color }}</span>
                        </span>
                    </p>
                    <p class="description-timeline">
                        CREATED AT: <span class="text-color block">{{ task.created_at }}</span> 
                        <br/>
                        UPDATES ON: <span class="text-color block">{{ task.updated_at }}</span>
                    </p>
                    <p>
                        <div class="colors-list right-colors-list">
                            <router-link to="/" class="button is-secendary color-list">Back</router-link>
                            <router-link :to="{name: 'editTask', params: {id: task.id}}" class="button is-primary color-list">
                                Edit Task
                            </router-link>
                            
                            <!-- <div class="color-list separator"></div> -->

                            <a href="#" class="card-header-icon color-list small-box" aria-label="more options" title="ReStart and Show this ToDo" 
                                v-if="!task.publish" 
                                    v-on:click.prevent="publishTask(task.id)">
                                <span class="icon"><i class="fa " :class="{'fa-eye': !task.publish, check: !task.publish, 'fa-eye-slash': task.publish}" aria-hidden="true"></i></span>
                            </a>
                            <a href="#" class="card-header-icon color-list small-box" aria-label="more options" title="Finish and hide this ToDo" 
                                v-else 
                                    v-on:click.prevent="publishTask(task.id)">
                                <span class="icon"><i class="fa " :class="{'fa-eye': !task.publish, check: !task.publish, 'fa-eye-slash': task.publish}" aria-hidden="true"></i></span>
                            </a>
                            <a class="card-header-icon color-list small-box" title="Delete ToDo" v-on:click.prevent="deleteTask(task.id)">
                                <span class="icon">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </span>
                            </a>
                        </div>
                    </p>
                </div>

                

            </div>
        </div>
    </div>
</template>

<script>
    export default {
    	directives: {
            'autofocus': {
                inserted(el) {
                    el.focus();
                }
            }
        },
        data() {
            return {
                errors:[],
                list: [],
                task: {
                    id: '',
                    title: '',
                    body: '',
                    color: '',
                    publish: '',
                },
                invite_lists: [],
                invite_list: {
                    id: '',
                    title: '',
                    body: '',
                    color: '',
                    publish: '',
                },
                inviteInput: {
                    id: '',
                    email: '',
                },
                userDetails: {},
                rows: [],
            }
        },
        created() {
        	let app = this;
        	let id = app.$route.params.id;
        	// console.log(id);
            this.initPageData(id);
        },
        methods: {
            emptyValue() {
                this.task.title = '';
                this.task.body = '';
                this.task.color = '';
            },
            initPageData(id) {
                this.fetchTaskList(id); 
                this.fetchInviteUsers(id);
            },
            fetchInviteUsers(id) {
                axios.get('invite_show/'+id)
                    .then(result => {
                        this.invite_lists = result.data;
                        console.log(this.invite_lists);
                    });
            },
            fetchTaskList(id, publish = null) {
                axios.get('task_show/' + id).then(result => {
                    this.task = result.data.task;
                    this.userDetails = result.data.userDetails;
                    this.task.created_at = this.frontEndDateFormat(this.task.created_at);
                    this.task.updated_at = this.frontEndDateFormat(this.task.updated_at);
                    this.inviteInput.id = this.task.id;
                    console.log(this.task);
                });

                axios.get('taskRowData_show/' + id).then(result => {
                    this.rows = result.data;
                    // console.log(result.data);
                });
            },
            // taskUserDetails(id) {
            //     axios.get('user_detail').then(result => {
            //         this.task = result.data;
            //         console.log(this.task);
            //     })
            // },
            deleteTask(id) {
                if (confirm("Do you really want to delete it?")) {
                    axios.post('task_delete/' + 1).then(result => {
                        this.initPageData(id);
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            publishTask(id) {
                if (confirm("Finish Confirm!")) {
                    axios.post('task_publish/' + id).then(result => {
                        this.initPageData(id);
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            inviteUser(id) {
                axios.post('invite_create', this.inviteInput).then(result => {
                    this.emptyValue();
                    this.initPageData(id);
                }).catch(err => {
                    console.log(err);
                });
            },
            deleteInvite(id, taskID) {
                if (confirm("Do you really want to delete it?")) {
                    axios.post('invite_delete/' + id).then(result => {
                        this.initPageData(taskID);
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            frontEndDateFormat(date) {
                return moment(date, 'YYYY-MM-DD').format('Do MMM [of] YYYY, [at] h:mm a');
            },
        }
    }
</script>