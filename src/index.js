import React from 'react';
import ReactDom from 'react-dom';
import App from './app';

document.addEventListener('DOMContentLoaded', function() {
    var element = document.getElementById('mrs-dashboard-widget');
    if ( typeof element !== 'undefined' && element !== null ) {
        ReactDom.render( <App />, document.getElementById('mrs-dashboard-widget') );
    }
});