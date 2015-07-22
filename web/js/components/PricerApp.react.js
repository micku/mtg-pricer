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
                <div className="ui grid app">
                    <div className="sixteen wide column">
                        <div className="section">
                            <SearchField />
                        </div>
                    </div>
                    <div className="eleven wide column">
                        <div className="section">
                            <FoundCards />
                        </div>
                    </div>
                    <div className="five wide column">
                        <div className="">
                            <div className="section">
                                <WishList />
                            </div>
                        </div>
                    </div>
                </div>
               );
    }
});

module.exports = PricerApp;
