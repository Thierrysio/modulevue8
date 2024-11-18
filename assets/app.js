
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

import { createApp } from 'vue';
import HelloWorld from './composants/test.vue';
import GetProducts from './composants/ProductApp.vue';
import GetVilles from './composants/VilleApp.vue';
import GetFournisseurs from './composants/FournisseurApp.vue';

createApp(HelloWorld).mount('#app');
createApp(GetProducts).mount('#app2');
createApp(GetVilles).mount('#app3');
createApp(GetFournisseurs).mount('#app4');