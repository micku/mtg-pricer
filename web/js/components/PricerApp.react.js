var SearchField = require('../components/SearchField.react.js');
var FoundCards = require('../components/FoundCards.react.js');
var React = require('react');

defaultData = [];

var PricerApp = React.createClass({
    getInitialState: function(){
        return {cards: []};
    },
    loadCardsFromServer: function(term) {
        if(term.length<3) {
            this.setState({cards: []});
            return;
        }
        $.ajax({
            url: this.props.url.replace('{term}', term),
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({cards: data});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    componentDidMount: function() {
        //this.loadCardsFromServer();
    },
    handleSearchSubmit: function(data) {
        //this.setState({cards: cards});
        this.loadCardsFromServer(data.term);
    },
    render: function() {
        return (
                <div className="section app">
                    <div className="container">
                        <div className="row">
                            <div className="col l10">
                                <div className="section">
                                    <SearchField onSearchSubmit={this.handleSearchSubmit} />
                                    <FoundCards data={this.state.cards} />
                                </div>
                            </div>
                            <div className="col l2">
                                <div className="toc-wrapper pin-top">
                                    <div className="section">
                                        Temp
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
