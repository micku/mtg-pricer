var PricerApp = require('./components/PricerApp.react.js');
var React = require('react');
window.React = React;

React.render(
        <PricerApp url="/api/search/{term}/" />,
        document.getElementById('app')
);
