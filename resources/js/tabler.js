/*
* Author: Md. Mazba Kamal
* Version: 1.0
* Website: www.mazbakamal.com
* Contact: mazba.cse@gmail.com
* Copyright : www.mazbakamal.com
* */

import './src/autosize';
import './src/input-mask';
import './src/dropdown';
import './src/tooltip';
import './src/popover';
import './src/switch-icon';
import { EnableActivationTabsFromLocationHash } from './src/tab';
import './src/toast';

EnableActivationTabsFromLocationHash();
window.$ = window.jQuery = require('jquery');
window.bootstrap = require('bootstrap');
require( 'datatables.net-bs5' );
