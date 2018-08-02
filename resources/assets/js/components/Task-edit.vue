<template>

    <div class="">

        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 text-center" v-if="messages.type">
            <div class="alert " role="alert" v-bind:class="{'alert-success': messages.type == 'success', 'alert-danger': messages.type == 'error'}">{{messages.message}}</div>
        </div>

        <div class=" col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
            <div class="box clearfix" style="background-color: #69437b;">
                
                <div class="tabs is-centered">
                    <ul>
                        <li class="is-active"> 
                            <h4 class="">
                                <a href="#">
                                    Edit Task
                                </a>
                            </h4>
                        </li>
                    </ul>
                </div>
                <form class="" >
                    <div class="form-group light-text">
                        <label>Task Color:</label>
                        <div class="colors-list">
                            <div class="color-list" v-for="radio_color in radio_colors">
                                <input type="radio" v-model="task.color" :value="radio_color.name" :id="radio_color.name" :checked="radio_color.name == task.color">
                                <label :for="radio_color.name" v-bind:style="{'background-color': radio_color.name}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group light-text">
                        <label for="exampleInputEmail1">Task Name:</label>
                        <input class="form-control" type="text" placeholder="New task" v-model="task.title">
                    </div>
                    <div class="form-group" id="tinymce-form">
                        <label for="exampleInputEmail1" class="light-text">Description</label>
                        <tinymce rows="10" v-model="task.body" :plugins="tinymce_plugins" :menubar="myMenubar"></tinymce>
                    </div>

                    <div class="form-group clearfix">
                        <div class="form-group">
                            <div class="input-group check-box" v-for="row in rows" v-bind:class="{ checked: row.status }">
                                <span class="input-group-addon v-select-2 vertical-top" >
                                    <label data-type="checkbox"><input type="checkbox" v-model="row.status"></label>
                                </span>
                                <textarea-autosize placeholder="Type something here..." ref="someName" rows="1" class="form-control v-select-2" v-model="row.body" :min-height="30" :max-height="350" ></textarea-autosize>
                                <span class="input-group-addon v-select-2 vertical-top"><i class="remove-row fa fa-times" v-on:click="removeElement(row)" style="cursor: pointer"></i></span>
                            </div><!-- /input-group -->
                        </div>
                        <div class="form-group clearfix">
                            <a href="#" class="btn pull-right btn-empty" @click.prevent="addRow">Add Another Items</a>
                        </div>
                    </div>

                    <div class="form-group">
			            <router-link to="/" class="button is-secendary">Back</router-link>
                        <router-link :to="{name: 'singleTask', params: {id: task.id}}" class="button is-secendary">
                                    Full View
                                </router-link>
			            <a class="button is-primary pull-right" v-on:click.prevent="updateTask(task.id)">Update Task</a>
			        </div>
                    
                </form>

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
        
        data: function () {
            return {
                messages: {
                    type: '',
                    message: '',
                },
                list: [],
                task: {
                    id: '',
                    title: '',
                    body: '',
                    color: '',
                    publish: ''
                },
                radio_colors: [
                    {name: 'white'}, {name: 'yellow'}, {name: 'green'}, {name: 'red'}, {name: 'blueviolet'}, {name: 'cornflowerblue'}, {name: 'mediumseagreen'}
                ],
                tinymce_plugins: [
                    'advlist autolink lists link image charmap print preview anchor','searchreplace visualblocks code fullscreen','insertdatetime media table contextmenu paste code codesample wordcount colorpicker code'
                ],
                myMenubar: false,
                rows: [],
                rowsDelete: [
                    // { id: 1 },
                    // { id: 2 }
                ],
            }
        },
        created() {
        	let app = this;
        	let id = app.$route.params.id;
            this.fetchTaskList(id);
        },
        methods: {
            fetchTaskList(id, publish = null) {
                axios.get('task_show/' + id).then(result => {
                    this.task = result.data.task;
                    // console.log(result.data);
                });

                axios.get('taskRowData_show/' + id).then(result => {
                    this.rows = result.data;
                    // console.log(result.data);
                });

            },
            updateTask(id) {
                axios.put('task_update/' + id, this.task).then(result => {
                    this.task.title = '';
                    this.task.body = '';
                    this.task.color = '';
                    this.fetchTaskList(id);
                    this.createTaskRowData(id);
                }).catch(err => {
                    console.log(err);
                });
            },
            createTaskRowData(id) {
                axios.post('taskRowData_Create', {taskRowData: this.rows, deleteRows: this.rowsDelete}).then(result => {
                    // console.log(result.data);
                    this.task.title = '';
                    this.task.body = '';
                    this.task.color = '';
                    this.fetchTaskList(id);

                    this.messages = {
                        type: 'success',
                        message: "Task Row Data Successfully Updated."
                    }
                }).catch(err => {
                    console.log(err);
                });
            },


            addRow: function () {
                this.rows.push({ id: "", task_id: this.task.id, status: false, body: "", created_at: "", updated_at: "", delete: false});
            },
            removeElement: function (row) {
                var index = this.rows.indexOf(row);

                if( this.rows[index].id ) {
                    this.rowsDelete.push({id: this.rows[index].id});
                }
                this.rows.splice(index, 1);
            },
            setFilename: function (event) {
                this.filename = event.target.name;
            }
        }
    }
</script>
