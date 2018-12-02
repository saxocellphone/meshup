class meshup{
    constructor(username, graph){
        this.username_ = username;
        this.graph_ = graph;
        // this.url_ = url;
        this.continuous_ = false;
    }

    async fetchStatus(interval = false){
        $.ajax({
            url: '?&component=api&function=get_status',
            method: 'POST'
        }).done((data) => {
            data = JSON.parse(data);
            let json = JSON.parse(data['json']);
            if(data['status'] == "success" && json != null){
                if(confirm("You have an incomming request from " + json['connect_from'] + ", accept or reject?")){
                    this.acceptConnection(json['connect_from']);
                } else {
                    this.rejectConnection(json['connect_from']);
                }
            }
        });
        if(interval){
            this.continuous_ = true;
            setTimeout(() => {
                this.fetchStatus(true);
            }, 2000);
        }
    }

    acceptConnection(incomming_username){
        $.ajax({
            url: '?&component=api&function=accept_request',
            method: 'POST',
            data: {
                'incomming_username': incomming_username
            }
        }).done((data) => {
            data = JSON.parse(data);
            if(data['status'] == 'success'){
                window.selfnode.addConnection(this.graph_.getNodeByUsername(incomming_username));
                alert("Success!");
            } else {
                alert("Something went wrong");
            }
        });
    }

    rejectConnection(incomming_username){
        $.ajax({
            url: '?&component=api&function=reject_request',
            method: 'POST',
            data: {
                'incomming_username': incomming_username
            }
        })
    }

    stopFetch(){
        this.continuous_ =false;
    }
}

export default meshup;