var SearchField = require('../components/SearchField.react.js');
var FoundCards = require('../components/FoundCards.react.js');
var WishList = require('../components/WishList.react.js');
var React = require('react');

defaultData = [];

var PricerApp = React.createClass({
    getInitialState: function(){
        return {cards: []};
    },
    componentDidMount: function() {
    },
    handleSearchSubmit: function(data) {
        this.loadCardsFromServer(data.term);
    },
    render: function() {
        return (
                <div className="section app">
                    <div className="container">
                        <div className="row">
                            <div className="col l10">
                                <div className="section">
                                    <SearchField />
                                    <FoundCards />
                                </div>
                            </div>
                            <div className="col l2">
                                <div className="toc-wrapper pin-top">
                                    <div className="section">
                                        <WishList />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               );
    }
});

module.exports = PricerApp;
