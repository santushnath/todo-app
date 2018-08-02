<template>
    <div class="">
        <div class=" col-md-4 col-sm-5">
            <div class="box">
                <h2 class="title">New Task</h2>
                <hr>
                <form>
                    <div class="form-group ">
                        <label>Task Color:</label> 
                        <div class="colors-list">
                            <div class="color-list" v-for="radio_color in radio_colors">
                                <input type="radio" v-model="task.color" :value="radio_color.name" :id="radio_color.name" :checked="task.color == activeColor">
                                <label :for="radio_color.name" v-bind:style="{'background-color': radio_color.name}"></label>
                            </div>
                        </div>
                        <!-- <chrome-picker :value="#ff0000" @input="updateValue"></chrome-picker> -->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Task Name:</label>
                        <input class="form-control" type="text" placeholder="New task" v-model="task.title">
                    </div>
                    <div class="form-group" id="tinymce-form">
                        <label for="exampleInputEmail1">Description</label>
                        <!-- <textarea class="form-control" id="editor" rows="8" placeholder="Description" v-model="task.body"></textarea> -->
                        <tinymce name="myTinymce" v-model="task.body"></tinymce>
                    </div>

                    <a class="button is-primary" @click="createTask()">Add Todo</a>
                </form>
            </div>
        </div>
        <div class=" col-md-8 col-sm-7">
            <div class="box clearfix" style="background-color: #69437b; padding-bottom: 0px;">
                
                <div class="tabs is-centered">
                    <ul>
                        <li :class="{'is-active':isActive('current')}">
                            <h4 class="">
                                <a href="#" v-on:click.prevent="fetchTaskList()">
                                    Current Task
                                </a>
                            </h4>
                        </li>
                        <li :class="{'is-active':isActive('share')}">
                            <h4 class="">
                                <a href="#" v-on:click.prevent="fetchTaskList(2)">
                                    Share Task
                                </a>
                            </h4>
                        </li>
                        <li :class="{'is-active':isActive('publish')}">
                            <h4 class="">
                                <a href="#" v-on:click.prevent="fetchTaskList(1)">
                                    Finish Tasks
                                </a>
                            </h4>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="todo-tasks">
                <div class="todo-task" v-for="task in list">
                    <div class="card" >
                        <header class="card-header">
                            
                                <router-link :to="{name: 'singleTask', params: {id: task.id}}" class="card-header-title">
                                    <p class="">
                                    {{ task.title }}
                                    </p>
                                </router-link>
                            
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
                        </header>
                        <div class="card-content card-color" v-bind:style="{ 'border-left-color': task.color }">
                            <div class="content">
                                <div class="read-more-area" v-if="task !== editingTask" @dblclick="editTask(task)" v-bind:title="message">
                                    <div class="task-description" v-html="task.body"></div>
                                </div>
                                
                                <textarea class="form-control read-more-textarea" id="editor" placeholder="Description" v-if="task === editingTask" v-autofocus @keyup.enter="endEditing(task)" @blur="endEditing(task)" v-model="task.body"></textarea>
                                <!-- <input class="input" v-if="task === editingTask" v-autofocus @keyup.enter="endEditing(task)" @blur="endEditing(task)" type="text" placeholder="New task" v-model="task.body"> -->
                            <p>
                                <router-link :to="{name: 'singleTask', params: {id: task.id}}" class="btn btn-xs btn-default">
                                    Full View
                                </router-link>
                                <router-link :to="{name: 'editTask', params: {id: task.id}}" class="btn btn-xs is-primary">
                                    Edit Task
                                </router-link>
                            </p>
                            </div>
                        </div>
                        <!-- <footer class="card-footer">
                            
                        </footer> -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>


<script>
    import readMore from '../readMore.js';
    export default {
        directives: {
            'autofocus': {
                inserted(el) {
                    el.focus();
                }
            },
        },
        // components: {
        //     tinymce
        // },
        data() {
            return {
                message: 'Double click for editing.',
                list: [],
                task: {
                    id: '',
                    title: '',
                    body: '',
                    color: 'white',
                    publish: '',
                },
                editingTask: {},
                activeItem: 'current',
                radio_colors: [{name: 'white'}, {name: 'yellow'}, {name: 'green'}, {name: 'red'}, {name: 'blueviolet'}, {name: 'cornflowerblue'}, {name: 'mediumseagreen'}],
                activeColor: 'white',
                content: 'hello world'
            }
        },
        created() {
            this.fetchTaskList();
        },
        methods: {
            fetchTaskList(publish = null) {
                if (publish === null) {
                    var url = 'tasks_current';
                    this.setActive('current');
                } else if(publish === 1) {
                    var url = 'tasks_published';
                    this.setActive('publish');
                }
                else if(publish === 2) {
                    var url = 'tasks_shared';
                    this.setActive('share');
                }
                axios.get(url).then(result => {
                    this.list = result.data;
                });
            },
            isActive(menuItem) {
                return this.activeItem === menuItem;
            },
            setActive(menuItem) {
                this.activeItem = menuItem;
            },
            createTask() {
                axios.post('task_create', this.task).then(result => {
                    this.task.title = '';
                    this.task.body = '';
                    this.task.color = 'white';
                    this.fetchTaskList();
                }).catch(err => {
                    console.log(err);
                });
            },
            editTask(task) {
                this.editingTask = task;
            },
            endEditing(task) {
                this.editingTask = {};
                if (task.body.trim() === '') {
                    this.deleteTask(task.id);
                } else {
                    axios.post('task_edit', task).then(result => {
                        console.log('access!')
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            deleteTask(id) {
                if (confirm("Do you really want to delete it?")) {
                    axios.post('task_delete/' + id).then(result => {
                        this.fetchTaskList();
                        console.log(result.data);
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            publishTask(id) {
                if (confirm("Finish Confirm!")) {
                    axios.post('task_publish/' + id).then(result => {
                        this.fetchTaskList();
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            excerptBody: readMore

        }
    }

    


</script>
