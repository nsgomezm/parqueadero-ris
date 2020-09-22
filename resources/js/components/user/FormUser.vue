<template>
    <div>
        <form autocomplete="off" v-on:submit.prevent="store" >
            <div class="form-group" v-if="newUser == true">
                <label for="cedula">Cedula</label>
                <input type="text" class="form-control" id="cedula" v-model="data.personal_information.cedula" name="cedula" v-validate="'required|numeric'" v-on:blur="CedulaValidate()" required>
                <span class="text-danger">{{ errors.first('cedula') }}</span>

            </div>
            <div class="form-group">
                <label for="nickname">Usuario</label>
                <input type="text" class="form-control" id="nickname" v-model="data.nickname" name="nickname" v-validate="'required'" v-on:blur="nicknameValidate()" :disabled="data.nickname != ''" required>
                <span class="text-danger">{{ errors.first('nickname') }}</span>
            </div>
            <div class="form-group">
                <label for="email">Correo electronico</label>
                <input type="email" class="form-control" id="email" v-model="data.email" name="email" v-validate="'required|email'"  autocomplete="off" ref="email" :disabled="data.email != ''" v-on:blur="emailVelidate()" required>
                <span class="text-danger">{{ errors.first('email') }}</span>
            </div>
            <div class="form-group" v-if="newUser == true">
                <label for="emailConfirm">Confirmar electronico</label>
                <input type="email" class="form-control" id="emailConfirm" v-model="data.emailConfirm" name="email_confirm" v-validate="'required|confirmed:email'" data-vv-as="email" required>
                <span class="text-danger">{{ errors.first('email_confirm') }}</span>

            </div>
            <div class="form-group" v-if="newUser == true">
                <label for="passwordactual">Contraseña</label>
                <input type="password" class="form-control" id="passwordactual" v-model="data.password" name="password" v-validate="'required'"  autocomplete="off" ref="password" required>
            </div>
            <div class="form-group" v-if="newUser == true">
                <label for="passwordconfirm">confirmar contraseña</label>
                <input type="password" class="form-control" id="passwordconfirm" name="password_confirm" v-validate="'required|confirmed:password'" data-vv-as="password" required>
            </div>
            <div class="form-group" v-if="newUser == false">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Rol</label>
                    </div>
                    <select class="custom-select" id="status" v-model="data.roles[0].name" v-on:change="validateRole()">
                        <option value="S.Admin">Super Administrador</option>
                        <option value="Admin">Adminsitrador</option>
                        <option value="patio">Patio</option>
                    </select>
                </div>
            </div>
            <div class="form-group" >
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Estado</label>
                    </div>
                    <select class="custom-select" id="status" v-model="data.status">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6" v-if="newUser == false">
                    <label for="created_at">Fecha creación</label>
                    <input type="datetime" class="form-control" id="created_at" v-model="data.created_at" disabled>
                </div>
                <div class="form-group col-12 col-md-6" v-if="newUser == false">
                    <label for="updated_at">Ultima actualización</label>
                    <input type="datetime" class="form-control" id="updated_at" v-model="data.updated_at" disabled>
                </div>
            </div>
            <div class="input-group d-flex justify-content-around align-items-center m-auto my-4" style="max-width: 500px">
                <a href="/users/list">Regresar</a>
                <input type="submit" value="Actualizar" class="btn btn-success">
            </div>
        </form>
    </div>
</template>

<script>
    var moment = require('moment')

    export default {
        props:['user'],
        data() {
            return {
                newUser: true,
                data: {
                    nickname: '',
                    email:'',
                    emailConfirm:'',
                    password:'',
                    status: 'inactivo',
                    personal_information:{
                        cedula: '',
                        name: '',
                        last_name: '',
                        cel: '',
                        photo: '/images/persons/admins/noimage.png',
                        address: '',
                        comments: 'Sin comentarios',
                    }
                },
            }
        },
        created(){
            this.getUser()
        },
        methods:{
            async getUser(){
                if(this.user){
                    this.data = this.user
                    this.newUser = false
                }
            },
            async CedulaValidate(){
                if(this.data.personal_information.cedula != '') {
                    await axios.get(`/api/validate/cedula/${this.data.personal_information.cedula}`).then(res => {
                        if(!$.isEmptyObject(res.data)){
                            document.getElementById("cedula").focus();
                            this.data.personal_information.cedula = '';
                            swal('Identification already been taken');
                        }
                    })
                }
            },
            async nicknameValidate(){
                if(this.data.nickname != '') {
                    await axios.get(`/api/validate/nickname/${this.data.nickname}`).then(res => {
                        if(!$.isEmptyObject(res.data)){
                            document.getElementById("nickname").focus();
                            this.data.nickname = '';
                            swal('nickname already been taken');
                        }
                    })
                }
            },
            async emailVelidate(){
                if(this.data.email != '') {
                    await axios.get(`/api/validate/email/${this.data.email}`).then(res => {
                        if(!$.isEmptyObject(res.data)){
                            document.getElementById("email").focus();
                            this.data.email = '';
                            this.data.emailConfirm = '';
                            swal('email already been taken');
                        }
                    })
                }
            },
            async validateRole(){
                if(this.data.roles[0].name == 'S.Admin'){
                    swal('¿Estas seguro?', `si asignas el rol de Super adminsitrador a ${this.data.personal_information.name} tendra todo el control la plataforma`, 'warning')
                }
            },

            async store(){
                var url = '/users/edit-information/user/'
                if(this.newUser == false){ url += this.data.id }

                // No funciona para crear un usuario
                try{
                    await axios.post(url, this.data).then(res => {
                        if(res.data.error != false){
                            // swal(res.data.title, res.data.menssage, "error")
                        // }else{
                            if(this.newUser == true){
                                swal(res.data.title, res.data.menssage, "success")
                                .then(xx => {
                                    window.location.href = `/users/edit-information/${res.data.user.id}`
                                })
                            }else{
                                swal(res.data.title, res.data.menssage, "success")
                            }
                        }
                    })
                }catch(error){
                    swal('Error', 'No se guardo correctamente. por favor intentelo nuevamente', 'error')
                }
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
