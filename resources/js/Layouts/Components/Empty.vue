<template>
    <div>
        <a-empty image="https://gw.alipayobjects.com/mdn/miniapp_social/afts/img/A*pevERLJC9v0AAAAAAAAAAABjAQAAAQ/original"
                 :image-style="{ height: '100px', margin:'auto', textAlign: 'center'}" >
            <span slot="description">  Aún no existen <b>{{title}}</b> para mostrar. </span>
        </a-empty>
    </div>
</template>

<script>
    export default {
        name: "Empty",
        props:['title']
    }
</script>

<style scoped>

</style>
