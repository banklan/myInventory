<<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <main-wrap></main-wrap>
        </div>
    </div>
</template>

<style lang="scss">
    .admin_wrap{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: -2.5rem;

        .sidebar{
            flex: 1 1 23%;
            background: #000123;
            height: 100vh;
            color: #ababab;
            padding: 1rem 0;
        }

        .main{
            flex: 1 1 77%;
        }
    }
</style>