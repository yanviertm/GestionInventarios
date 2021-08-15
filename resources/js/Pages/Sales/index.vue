<template>
    <layout menuActive="6">
        <a-divider orientation="left">
            <h4 class="color--secondary">Mis Ventas</h4>
        </a-divider>

            <a-row type="flex" justify="center" align="top">
                <a-table :columns="columns" :data-source="dataSale">
                    <span slot="name" slot-scope="name">{{ name }}</span>
                    <span slot="lastname" slot-scope="lastname">{{lastname}}</span>
                    <span slot="product" slot-scope="product">{{ product }}</span>
                    <span slot="discount" slot-scope="discount">{{ discount }}</span>
                    <span slot="price" slot-scope="price">{{price}}</span>
                    <span slot="date" slot-scope="date">{{date}}</span>
                </a-table>
            </a-row>
        <a-divider />
        <br>
    </layout>
</template>

<script>
import Layout from './../../Layouts/Layout';
import Empty from "../../Layouts/Components/Empty";
import ErrorForm from "../../Layouts/ErrorForm";
import axios from 'axios';
export default {
    name: "index",
    components: {Layout, Empty, ErrorForm},
    props: ['sales'],
    data:()=>({
        columns:[
            {
                title: 'Nombre',
                dataIndex: 'name',
                key: 'name',
            },
            {
                title: 'Apellidos',
                key: 'lastname',
                dataIndex: 'lastname',
            },
            {
                title: 'Nombre de Producto',
                key: 'product',
                dataIndex: 'product',
            },
            {
                title: 'Precio',
                key: 'price',
                dataIndex: 'price',
            },
            {
                title: 'Descuento',
                key: 'discount',
                dataIndex: 'discount',
            },
            {
                title: 'Fecha',
                key: 'created_at',
                dataIndex: 'created_at',
            },
        ],
        csrfToken:'',
        dataSale: [],
        loadingOnSave:false,

    }),
    mounted() {
        this.dataSale = this.sales;
    }
}
</script>

<style scoped>

</style>
