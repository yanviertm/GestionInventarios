<template>
    <div>
        <a-alert v-show="err.info != null" message="Debe revisar su formulario" type="error" show-icon>
      <span slot="description">
        <ul>
          <li>{{ err.info }}</li>
        </ul>
      </span>
        </a-alert>
    </div>
</template>
<script>
export default {
    name:'ErrorForm',
    data() {
        return {};
    },
    props: ["err"],
};
</script>
