
import Admin from './components/Admin/Admin.vue';
import AllUsers from './components/Admin/AdminAllUsers.vue';
import AdminUser from './components/Admin/AdminUser.vue';
import AdminFrontOfficeUser from './components/Admin/AdminFrontOfficeUser.vue';
import AdminSupervisorSingle from './components/Admin/AdminSupervisorSingle.vue';
import Test from './components/test.vue';
import Nav from './components/nav.vue';
import Inventory from './components/Admin/AdminInventory.vue';
import Settings from './components/Admin/AdminSettings.vue';
import Roles from './components/Admin/AdminRoles.vue';
import AllAdmins from './components/Admin/AllAdmins.vue';
import AllSupervisors from './components/Admin/AllSupervisors.vue';
import AllSales from './components/Admin/AdminAllSales.vue';
import AdminUserSearchresult from './components/Admin/AdminUserSearchresult.vue';
import AllProducts from './components/Admin/AdminProducts.vue';
import AdminProdCateg from './components/Admin/AdminProdCateg.vue';
import AdminSingleProd from './components/Admin/AdminSingleProd.vue';
import AdminStock from './components/Admin/Stock.vue';
import AdminSales from './components/Admin/AdminSales.vue';
import AdminSingleSale from './components/Admin/AdminSingleSale.vue';
import SupervisorHome from './components/Supervisor/Home.vue';
import SupAllStocks from './components/Supervisor/SupAllStocks.vue';
import SupNewStock from './components/Supervisor/SupNewStock.vue';
import SupAllSales from './components/Supervisor/SupAllSales.vue';
import SupSale from './components/Supervisor/SupSingleSale.vue';
import SupAllProducts from './components/Supervisor/SupAllProducts.vue';
import SupNewProd from './components/Supervisor/SupNewProd.vue';
import Testsup from './components/Supervisor/Test.vue';
import SupSettings from './components/Supervisor/SupSettings.vue';
import addStock from './components/Supervisor/SupAddStock.vue';
import SupProdSearch from './components/Supervisor/SupProductSearchResult.vue';
import SupProdsSearch from './components/Supervisor/SupProductSearchResult2.vue';
import SupProdShow from './components/Supervisor/SupProdShow.vue';
import SalesUserHome from './components/Sales/Home.vue';
import FrontSales from './components/Sales/FrontSales.vue';
import FrontStocks from './components/Sales/FrontStocks.vue';
// import FrontProducts from './components/Sales/FrontProducts.vue';
import FrontLogs from './components/Sales/FrontLogs.vue';
import FrontSettings from './components/Sales/FrontSettings.vue';
import frontCheckout from './components/Sales/frontCheckout.vue';
import salesCart from './components/Sales/frontSalesCart.vue';


export default[
    {path: '/admin', name: 'admin', component: Admin, props: true},
    {path: '/admin/all_users', name:'all_users', component: AllUsers, props: true},
    {path: '/admin/admins/:id', name:'AdminUser', component: AdminUser, props: true},
    {path: '/admin/front_office/:id', name:'AdminFrontOfficeUser', component: AdminFrontOfficeUser, props: true},
    {path: '/admin/supervisor/:id', name:'AdminSupervisorSingle', component: AdminSupervisorSingle, props: true},
    {path: '/admin/test', name:'Test', component: Test, props: true},
    {path: '/admin/sidenav', name:'Nav', component: Nav, props: true},
    {path: '/admin/roles', name:'Roles', component: Roles},
    // {path: '/admin/usersall', name:'UsersAll', component: UsersAll},
    {path: '/admin/inventory', name:'Inventory', component: Inventory},
    {path: '/admin/stock', name:'AdminStock', component: AdminStock},
    {path: '/admin/settings', name:'Settings', component: Settings},
    {path: '/admin/users/all_admins', name:'AllAdmins', component: AllAdmins},
    {path: '/admin/users/all_supervisors', name:'AllSupervisors', component: AllSupervisors},
    {path: '/admin/users/all_sales', name:'AllSales', component: AllSales},
    {path: '/admin/user_search_result', name:'AdminUserSearchresult', component: AdminUserSearchresult},
    {path: '/admin/products/categories', name:'AdminProdCateg', component: AdminProdCateg},
    {path: '/admin/products/products', name:'AllProducts', component: AllProducts},
    {path: '/admin/products/product/:id', name:'AdminSingleProd', component: AdminSingleProd},
    {path: '/admin/sales', name:'AdminSales', component: AdminSales},
    {path: '/admin/sales/:id', name:'AdminShowSale', component: AdminSingleSale},
    {path: '/supervisor', name: 'SupervisorHome', component: SupervisorHome, props: true},
    {path: '/supervisor/stocks/all_stocks', name: 'SupAllStocks', component: SupAllStocks},
    {path: '/supervisor/stocks/new_stock', name: 'SupNewStock', component: SupNewStock},
    {path: '/supervisor/all_sales', name: 'SupAllSales', component: SupAllSales},
    {path: '/supervisor/all_sales/:id', name: 'SupSale', component: SupSale},
    {path: '/supervisor/all_products', name: 'SupAllProducts', component: SupAllProducts},
    {path: '/supervisor/new_product', name: 'SupNewProd', component: SupNewProd},
    {path: '/supervisor/test', name: 'Testsup', component: Testsup},
    {path: '/supervisor/settings', name: 'SupSettings', component: SupSettings},
    {path: '/supervisor/add_stock/:id', name: 'addStock', component: addStock},
    {path: '/supervisor/stocks/search', name: 'SupProductSearchResult', component: SupProdSearch},
    {path: '/supervisor/product/search', name: 'SupProdsSearch', component: SupProdsSearch},
    {path: '/supervisor/product/:id', name: 'SupProdShow', component: SupProdShow},
    {path: '/home', name: 'SalesUserHome', component: SalesUserHome},
    {path: '/front_sales', name: 'FrontSales', component: FrontSales},
    {path: '/front_stocks', name: 'FrontStocks', component: FrontStocks},
    // {path: '/front_products', name: 'FrontProducts', component: FrontProducts},
    {path: '/front_logs', name: 'FrontLogs', component: FrontLogs},
    {path: '/front_settings', name: 'FrontSettings', component: FrontSettings},
    {path: '/frontsales_checkout/:id', name: 'frontCheckout', component: frontCheckout},
    {path: '/sales_cart', name: 'salesCart', component: salesCart},
  
]