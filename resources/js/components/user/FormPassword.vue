<template>
    <div>
        <form  v-on:submit.prevent="store">
            <div class="form-group">
                <label for="password-old">Contraseña actual</label>
                <input type="password" class="form-control" id="password-old" required>
            </div>
            <div class="form-group">
                <label for="password-new">Nueva contraseña</label>
                <input type="password" class="form-control" id="password-new" required>
            </div>
            <div class="form-group">
                <label for="password-confirm">Confirmar contraseña</label>
                <input type="password" class="form-control" id="password-confirm" required>
            </div>
            <div class="input-group d-flex justify-content-around align-items-center m-auto my-4" style="max-width: 500px">
                <input type="submit" value="Actualizar" class="btn btn-success">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        methods:{
            async store(){
                alert('save')
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
