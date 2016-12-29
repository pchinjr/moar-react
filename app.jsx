let ENTRIES = [
  {
    title: "The first post",
    content: "Seitan taxidermy cardigan kitsch cliche cray. Whatever stumptown authentic cardigan cold-pressed live-edge. Flexitarian typewriter ramps fanny pack, kale chips whatever photo booth deep v chicharrones kitsch food truck slow-carb.",
    id: 1,
  },
  {
    title: "The second post",
    content: "Affogato godard fingerstache, food truck leggings tattooed narwhal church-key heirloom kale chips pinterest wolf retro fashion axe PBR&B. Lyft selvage irony flannel, kickstarter fap tilde fashion axe single-origin coffee kogi letterpress cornhole.",
    id: 2,
  },
  {
    title: "The third post",
    content: "Asymmetrical taxidermy paleo church-key umami, tumeric fashion axe YOLO crucifix cardigan blue bottle small batch. Kickstarter enamel pin jianbing, hexagon lomo green juice poutine etsy raw denim. +1 pinterest narwhal, vinyl squid jianbing fanny pack activated charcoal photo booth farm-to-table plaid bitters.",
    id: 3,
  },
];

let nextId = 4;

const AddEntryForm = React.createClass({
  propTypes: {
    onAdd: React.PropTypes.func.isRequired,
  },
  
  getInitialState: function() {
    return {
      title: "",
      content: "",
    };
  },
  
  onTitleChange: function(e) {
    this.setState({title: e.target.value});
  },

  onContentChange: function(e) {
    this.setState({content: e.target.value})
  },
  
  onSubmit: function(e) {
    e.preventDefault();
  
    this.props.onAdd(this.state.title, this.state.content);
    this.setState({title: "", content: ""});
  },
  
  render: function() {
    return (
      <div className="row">
        <form className="col s12" onSubmit={this.onSubmit}>
          <div className="row">
            <div className="input-field col s3">
                <input type="text" value={this.state.title} onChange={this.onTitleChange} />
                <label className="active">Title</label>
            </div>
            <div className="input-field col s3">
                <input type="text" value={this.state.content} onChange={this.onContentChange} />
                <label className="active">Content</label>
            </div>
            <div className="input-field col s3">
                <input type="submit" value="Add Entry" className="waves-effect waves-light btn"/>
            </div>
         </div> 
        </form>
      </div>
    ); 
  }
});

function Entry(props) {
  return (
    <div className="row">
        <div className="col s12 m6">
            <div className="card blue-grey darken-1">
                <div className="card-content white-text">
                    <span className="card-title">{props.title}</span>
                    <p>{props.content}</p>
                </div>
                <div className="card-action">
                    <a className="remove-entry" onClick={props.onRemove}>✖ Delete</a>
                </div>
            </div>
        </div>
    </div>
  );
}

Entry.propTypes = {
  title: React.PropTypes.string.isRequired,
  content: React.PropTypes.string.isRequired,
  onRemove: React.PropTypes.func.isRequired,
};

const Application = React.createClass({
  propTypes: {
    title: React.PropTypes.string,
    initialEntries: React.PropTypes.arrayOf(React.PropTypes.shape({
      title: React.PropTypes.string.isRequired,
      content: React.PropTypes.string.isRequired,
      id: React.PropTypes.number.isRequired,
    })).isRequired,
  },
  
  getInitialState: function() {
    return {
      entries: this.props.initialEntries,
    };
  },

  onEntryAdd: function(title, content) {
    this.state.entries.push({
      title: title,
      content: content,
      id: nextId,
    });
    this.setState(this.state);
    console.log(this.state);
    nextId += 1;
  },

  onRemoveEntry: function(index) {
      this.state.entries.splice(index, 1);
      this.setState(this.state);
  },

  render: function() {
    return (
        <div className="container">
            {this.state.entries.map( (entry, index) =>
                (<Entry 
                    onRemove={function(){this.onRemoveEntry(index)}.bind(this)}
                    title={entry.title} 
                    content={entry.content} 
                    key={entry.id} 
                />)
            )}
            <AddEntryForm onAdd={this.onEntryAdd} />
        </div>
    );
  }
});  

ReactDOM.render(<Application initialEntries={ENTRIES} />, document.getElementById('container'));