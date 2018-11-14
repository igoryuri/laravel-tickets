<template>
    <div>

        <div class="card-content" style="overflow-y: auto; height: 450px;">

            <div class="card w-50 m-2" :class="data.userIdTicket == data.user_id ? 'bd-lightBlue place-left' : 'bd-lightRed place-right'"
                 v-for="data in monitorings">
                <div class="card-header fg-white" :class="data.userIdTicket == data.user_id ? 'bg-lightBlue text-white' : 'bg-lightRed text-white'">
                    <span class='mif-user-check mr-1'></span>
                    {{ data.name }}
                    <span class="small place-right">{{ moment(data.created_at, "YYYY-MM-DD").format("DD/MM/YYYY LT") }}</span>
                </div>
                <div class="card-content p-2">
                    {{ data.description }}

                </div>
                <!--<div class="card-footer" :class="data.userIdTicket == data.user_id ? 'bg-lightBlue text-white' : 'bg-lightRed text-white'">-->
                <!--<span class="small">{{ moment(data.created_at, "YYYY-MM-DD").format("DD/MM/YYYY LT") }}</span>-->
                <!--</div>-->
            </div>
        </div>
        <div class="card-footer">
            <div class="cell-md-12">
                <form @submit.prevent="save()" class="custom-validation" id="formSubmit">
                    <div class="row">
                        <div class="cell-md-10">
                            <textarea rows="3" id="description" name="description" data-role="textarea" data-auto-size="true" data-max-height="200"
                                      v-model="monitoring_to_save.description" required placeholder="Pressione Ctrl+Enter para salvar" autofocus>

                            </textarea>
                        </div>
                        <div class="cell-md-2">
                            <button class="button mt-2 w-100" type="submit" id="save">Salvar</button>
                            <button class="button mt-2 w-100" type="reset" id="reset">Limpar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    var pressedCtrl = false;
    $(document).keyup(function (e) {
        if (e.which == 17) pressedCtrl = false;
    });
    $(document).keydown(function (e) {
        if (e.which == 17) pressedCtrl = true;
        if ((e.which == 13 || e.keyCode == 13) && pressedCtrl == true) {
            $('#save').trigger('click');
        }
    });

    export default {
        props: [
            'ticketId',
            'ticketName',
            'userId',
        ],
        data() {
            return {
                monitorings: [],
                ticket_id: this.ticketId,
                monitoring_to_save: {
                    description: '',
                    ticket_id: this.ticketId,
                    user_id: this.userId
                }
            }
        },
        created() {
            this.listenForChanges();
        },
        methods: {
            save() {
                window.axios.post('/bioclin/monitorings', this.monitoring_to_save)
                    .then(() => {
                        this.getMonitorings();
                        this.monitoring_to_save.description = '';
                    })
            },
            getMonitorings() {
                window.axios.get('/bioclin/monitorings/' + this.ticket_id)
                    .then((response) => {
                        this.monitorings = response.data;
                    })

            },
            listenForChanges() {
                Echo.channel(`refresh.monitoring.` + this.ticket_id)
                    .listen('RefreshPusherEvent', post => {
                        if (!('Notification' in window)) {
                            alert('Web Notification is not supported');
                            return;
                        }
                        if (this.userId != post.monitoring.user_id) {
                            Notification.requestPermission(permission => {
                                let notification = new Notification(this.ticketName, {
                                    body: post.monitoring.description,
                                    icon: "http://hospitalar.com/media/com_jbusinessdirectory/pictures/companies/182/Avatar-1491592646.png"
                                });
                                notification.onclick = () => {
                                    window.open(window.location.href);
                                };
                            });
                        }
                    })
            },
        },
        mounted() {
            this.getMonitorings()
            Echo.channel(`refresh.monitoring.` + this.ticket_id)
                .listen('RefreshPusherEvent', (e) => {
                    if (e.monitoring) {
                        this.getMonitorings();
                    }
                })

        }
    }
</script>


<!--data.userIdTicket == data.user_id ? 'bd-lightBlue' : 'bd-lightRed'-->
