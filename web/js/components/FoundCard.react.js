var React = require('react');

var FoundCard = React.createClass({
    render: function() {
        var image_url = 'http://api.mtgdb.info/content/card_images/' + this.props.multiverse_id + '.jpeg';
        return (
                <div className="foundCard col s12 m3">
                    <div className="card small blue-grey darken-1">
                        <div className="card-image">
                          <img src={image_url} />
                          <p className="cardName card-title">{this.props.children}</p>
                        </div>
                        <div className="card-content white-text">
                            <i className="material-icons right"><a href="#">library_add</a></i>
                            <p className="cardName">{this.props.children}</p>
                        </div>
                    </div>
                </div>
               );
    }
});

module.exports = FoundCard;
