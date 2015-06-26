defaultData = [];

var App = React.createClass({
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
                <div className="app">
                    <SearchField onSearchSubmit={this.handleSearchSubmit} />
                    <FoundCards data={this.state.cards} />
                </div>
               );
    }
});

var SearchField = React.createClass({
    handleSubmit: function(e, a, b, c) {
        e.preventDefault();
        var term = React.findDOMNode(this.refs.searchTerm).value.trim();

        this.props.onSearchSubmit({'term': term});
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
                                <i className="material-icons right">search</i>
                            </button>
                        </div>
                    </form>
                </div>
               );
    }
});

var FoundCards = React.createClass({
    render: function() {
        var cardNodes = this.props.data.map(function(card) {
            return (
                    <FoundCard multiverse_id={card.multiverse_id}>
                        {card.name}
                    </FoundCard>
                   );
        });

        return (
                <div className="foundCards row">
                    {cardNodes}
                </div>
               );
    }
});

var FoundCard = React.createClass({
    render: function() {
        var image_url = 'http://api.mtgdb.info/content/card_images/' + this.props.multiverse_id + '.jpeg';
        return (
                <div className="foundCard col s12 m4">
                    <div className="card small blue-grey darken-1">
                        <div className="card-image">
                          <img src={image_url} />
                        </div>
                        <div className="card-content white-text">
                            {this.props.image}
                            <p className="cardName">{this.props.children}</p>
                        </div>
                    </div>
                </div>
               );
    }
});

React.render(<App url="/api/search/{term}/" />, document.getElementById('app'));
