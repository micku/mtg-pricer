var SearchActionCreators = require('../actions/SearchActionCreators');
var React = require('react');

var SearchField = React.createClass({
    getInitialState: function() {
        return {text: ''};
    },

    componentDidMount: function() {
        $(React.findDOMNode(this.refs.searchTerm)).focus();
    },

    handleSubmit: function(e, a, b, c) {
        e.preventDefault();
        var term = React.findDOMNode(this.refs.searchTerm).value.trim();

        SearchActionCreators.search(term);
        //this.props.onSearchSubmit({'term': term});
        return;
    },

    render: function() {
        return (
                <div className="row">
                    <form className="searchField col s12" onSubmit={this.handleSubmit}>
                        <div className="input-field col s8">
                            <input type="text" placeholder="Insert card name" ref="searchTerm" onChange={this.handleSubmit}>
                                {this.props.text}
                            </input>
                        </div>
                        <div className="input-field col s4">
                            <button type="submit" className="btn waves-effect waves-light blue-grey lighten-3">Search
                                <i className="fa fa-search fa-2x right"></i>
                            </button>
                        </div>
                    </form>
                </div>
               );
    }
});

module.exports = SearchField;
