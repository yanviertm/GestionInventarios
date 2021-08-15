<template>
    <div class="">
        <a-layout theme="light"  id="components-layout-demo-responsive" :style="{height:'100vh', overflowY: 'auto'}">
            <a-layout-sider
                breakpoint="lg"
                collapsed-width="0"
                @collapse="onCollapse"
                @breakpoint="onBreakpoint"
                theme="light">
                <div class="logo text-center" theme="light">
                    <a-avatar
                        style="width:100px;height:100px;"
                        slot="avatar"
                        src="images/logo.png"
                    />
                </div>
                <br>
                <br>
                <br>
                <br>
                <a-menu theme="light" mode="inline">
                    <a-menu-item key="1">
                        <inertia-link href="/dashboard">
                            <a-icon type="home" />
                            <span class="nav-text">Inicio</span>
                        </inertia-link>
                    </a-menu-item>
                    <a-menu-item key="2">
                        <inertia-link href="/productos">
                            <a-icon type="tags" />
                            <span class="nav-text">Productos</span>
                        </inertia-link>
                    </a-menu-item>
                    <a-menu-item key="3">
                        <inertia-link href="/categorias">
                            <a-icon type="container" />
                            <span class="nav-text">Categorías</span>
                        </inertia-link>
                    </a-menu-item>
                    <a-menu-item key="4">
                        <inertia-link href="/ventas">
                            <a-icon type="read" />
                            <span class="nav-text">Ventas</span>
                        </inertia-link>
                    </a-menu-item>
<!--                    <a-menu-item key="5">
                        <inertia-link href="/usuarios">
                            <a-icon type="user" />
                            <span class="nav-text">Usuarios</span>
                        </inertia-link>
                    </a-menu-item>-->
                    <a-menu-item key="6">
                        <inertia-link href="/clientes">
                            <a-icon type="team" />
                            <span class="nav-text">Clientes</span>
                        </inertia-link>
                    </a-menu-item>
                </a-menu>
            </a-layout-sider>
            <a-layout>
                <a-layout-header :style="{ background: '#fff', padding: 0 }" />
                <a-layout-content :style="{ margin: '24px 16px 0', minHeight: '85vh', overflowY: 'auto' }">
                    <div :style="{ padding: '24px', background: '#fff'}">
                        <!-- Page Content -->
                        <main :style="{minHeight: '80vh', overflowY: 'auto'}">
                            <slot></slot>
                        </main>
                    </div>
                </a-layout-content>
                <a-layout-footer style="textAlign: center">
                    Ant Design ©2018 Created by Ant UED
                </a-layout-footer>
            </a-layout>
        </a-layout>
    </div>
</template>

<script>
    export default {
        name: "Layout",
        props:['menuActive', 'srcLogo'],
        data(){
            return{

            }
        },
        methods:{
            onCollapse(collapsed, type) {
                console.log(collapsed, type);
            },
            onBreakpoint(broken) {
                console.log(broken);
            },
        },
    }
</script>

<style>
    :root{
        --color-primary: #1A5CFF;
        --color-success: #47C93A;
        --color-danger: #FF4757;
        --color-warning: #FFBA02;
        --color-dark: #1E1E1E;
        --color-light: #F2F2FC;
        --color-white:white;
        --color-secondary:#030420;
    }
    html,body{
        font-size: 1rem;
    }

    h1{
        font-weight: bold;
        font-size: 2.5rem;
    }

    h2{
        font-weight: bold;
        font-size: 2rem;
    }

    h3{
        font-weight: bold;
        font-size: 1.5rem;
    }

    h4{
        font-weight: bold;
        font-size: 1rem;
    }

    h5{
        font-weight: bold;
        font-size: .8rem;
    }

    h6{
        font-weight: bold;
        font-size: .6rem;
    }

    b{
        font-weight: bold;
    }

    .color-primary{
        color: var(--color-primary);
    }

    .bg--primary{
        background: var(--color-primary);
    }

    .color-secondary{
        color: var(--color-secondary);
    }

    .bg--secondary{
        background: var(--color-secondary);
    }
    .color-success{
        color: var(--color-success);
    }

    .bg--success{
        background: var(--color-success);
    }
    .color-danger{
        color: var(--color-danger);
    }

    .bg--danger{
        background: var(--color-danger);
    }
    .color-warning{
        color: var(--color-warning);
    }

    .bg--warning{
        background: var(--color-warning);
    }
    .color-dark{
        color: var(--color-dark);
    }

    .bg--dark{
        background: var(--color-dark);
    }

    #components-layout-demo-responsive{
        background: red;
    }

    #components-layout-demo-responsive .logo {
        height: 32px;
        background: var(--color-white);
        margin: 16px;
    }

    .loading-spinner{
        transition: 0.3s;
        background:rgba(255,255,255, 0.8);
        position:fixed;
        top:0;
        left:0;
        height: 100vh;
        width:100vw;
        display: table;
        z-index: 3000 !important;
    }
    .loading-spinner i{
        display: table-cell;
        vertical-align: middle;
    }
    .text-center{
        text-align: center !important;
    }
    .align-middle{
        vertical-align: middle !important;
    }
    .ant-empty-image img{
        margin:auto;
    }
</style>
