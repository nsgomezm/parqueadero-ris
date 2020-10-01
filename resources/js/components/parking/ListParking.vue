<template>
    <div class="px-4">
        <div class="navbar navbar-light mb-3">
            <button type="button" class="btn btn-success mb-2"  data-toggle="modal" data-target="#newParking">
                Registrar
            </button>
        </div>
        <div v-if="!show">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Ris-Park</h4>
                <p>Ris-Park te informa que no tienes parqueaderos registrados en el sistema</p>
                <hr>
                <p class="mb-0">Para ingresar un nuevo parquedero puede dar click en el boton "Registrar" o dar <a href="#" data-toggle="modal" data-target="#newParking">click aqui</a></p>
            </div>
        </div>
        <div class="table-responsive" v-else>
            <table class="table table-hover w-100" id="table-parking">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nit</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Administrador</th>
                        <th scope="col">Fecha Creación</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(parking, index) in parkings" :key="index">
                        <th>{{ index+1 }}</th>
                        <td>{{ parking.nit }}</td>
                        <td>{{ parking.name }}</td>
                        <td>{{ parking.cel }}</td>
                        <td>{{ parking.address }}</td>
                        <td>
                            <p v-if="parking.user != null">
                                <a :href="`/users/edit-information/${parking.user.personal_information.id}`" target="_blank">{{ parking.user.personal_information.name }} </a></p>
                            <p v-else>
                                Sin administrador
                            </p>
                        </td>
                        <td>{{ parking.created_at }}</td>
                        <td><a :href="`/Parking/edit-information/${parking.id}`" class="d-block text-center text-primary"><i class="fas fa-user-edit"></i></a></td>
                        <td><a href="#" class="d-block text-center text-danger" v-on:click="deleteParking(parking)"><i class="fas fa-user-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="newParking" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 20000">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <parking-form :data="false" @event="newParking = $event"></parking-form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from './form'

    export default {
        props: ['data'],
        components:{
            'parking-form' : Form,
        },
        data(){
            return {
                show: false,
                parkings: this.data,
                newParking: null,
            }
        },
        created() {
            if(this.data.length != 0){
                this.show = true
            }

        },
        mounted(){
            this.getTableParking()
        },
        methods:{
            getTableParking(){
                $("#table-parking").DataTable({
                    "language":{
                        "url" : "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                    }
                })
            },

            async deleteParking(parking){
                swal({
                    title: "Confirmar eliminación",
                    text: "Si eliminas el parquedero "+parking.name+ " no podras recuperar su información",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.delete(parking)
                    }
                })
            },

            async delete(parking){
                await axios.post(`/Parking/edit-information/delete/${parking.id}`).then(res => {
                    this.parkings = res.data.parkings
                    if(this.parkings.length == 0){
                        this.show = false
                    }
                    swal('',parking.name + " se eliminó con exito", 'success')
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
