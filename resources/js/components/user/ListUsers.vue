<template>
    <div class="container">
        <div class="navbar navbar-light mb-3">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#newUser">
                Registrar
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover w-100" id="table-users">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                        <th>{{ index+1 }}</th>
                        <td>{{ user.personal_information.name }}</td>
                        <td>{{ user.personal_information.last_name }}</td>
                        <td>{{ user.personal_information.cel }}</td>
                        <td>{{ user.nickname }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.roles[0].name }}</td>
                        <td :class="(user.status == 'activo') ? 'text-success' : 'text-danger'">{{ user.status }}</td>
                        <td><a :href="`/users/edit-information/${user.id}`" class="d-block text-center text-primary"><i class="fas fa-user-edit"></i></a></td>
                        <td><a href="#" class="d-block text-center text-danger" v-on:click="deleteUser(user)"><i class="fas fa-user-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="newUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 20000">
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
                            <form-user :user="false"></form-user>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FormUser from './FormUser'

    export default {
        props: ['data'],
        components:{
            FormUser,
        },
        data(){
            return{
                users: JSON.parse(this.data),
            }
        },
        mounted() {
            this.getTableUsers()
        },

        created(){
            // swal('Bienvenido')
        },

        methods:{
            getTableUsers(){
                $("#table-users").DataTable({
                    "language":{
                        "url" : "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                    },
                    responsive: "true",
                })
            },
            async deleteUser(user){
                // swal('Confirmar eliminación', '¿seguro que deseas eliminar a ' + user.personal_information.name +'?', 'warning')
                swal({
                    title: "Confirmar eliminación",
                    text: "Si eliminas a "+user.personal_information.name+ " no podras recuperar su información",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.delete(user)
                    }
                })
            },

            async delete(user){
                await axios.post(`/users/edit-information/delete/${user.id}`).then(res => {
                    this.users = res.data.users
                    swal('',user.personal_information.name + " se eliminó con exito", 'success')
                })
            }
        }

    }
</script>
