var SearchActionCreators = require('../actions/SearchActionCreators');
var CardStore = require('../stores/CardStore');
var React = require('react');
var classNames = require('classnames');

var SearchField = React.createClass({

    getInitialState: function() {
        return {text: '', loading: false};
    },

    componentDidMount: function() {
        $(React.findDOMNode(this.refs.searchTerm)).focus();
        CardStore.addSearchListener(this.setLoading);
        CardStore.addReceiveSearchListener(this.setNotLoading);
    },

    componentWillUnmount: function() {
        CardStore.removeSearchListener(this.setLoading);
        CardStore.removeReceiveSearchListener(this.setNotLoading);
    },

    setLoading: function() {
        var newState = this.state;
        newState.loading = true;
        this.setState(newState);
    },

    setNotLoading: function() {
        var newState = this.state;
        newState.loading = false;
        this.setState(newState);
    },

    handleSubmit: function(e, a, b, c) {
        e.preventDefault();
        var term = React.findDOMNode(this.refs.searchTerm).value.trim();

        SearchActionCreators.search(term);
        return;
    },

    render: function() {
        var classes = classNames({
            'ui': true,
            'action': true,
            'left': true,
            'icon': true,
            'input': true,
            'fluid': true,
            'loading': this.state.loading
        });
        return (
                <form className="searchField col s12" onSubmit={this.handleSubmit}>
                    <div className={classes}>
                        <i className="search icon"></i>
                            <input type="text" placeholder="Insert card name" ref="searchTerm" onChange={this.handleSubmit}>
                                {this.state.text}
                            </input>
                            <button type="submit" className="ui teal button">Search</button>
                    </div>
                </form>
               );
    }
});

module.exports = SearchField;
