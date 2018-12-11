/**
 * This class is the core app of meshup. It connects to meshup's php API. It can fetch status, send requets, and live update.
 */


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
            try{
                data = JSON.parse(data);
            } catch {
    
            }
            let json = data['json'];
            try{
                json = JSON.parse(json);
            } catch {
                
            }
            
            if(data['status'] == "success" && json != null){
                let new_requests = json['new_requests'];
                if(new_requests != null){
                    if(confirm("You have an incomming request from " + new_requests['connect_from'] + ", accept or reject?")){
                        this.acceptConnection(new_requests['connect_from']);
                    } else {
                        this.rejectConnection(new_requests['connect_from']);
                    }
                }

                let new_edges = json['new_edges'];
                if(new_edges.length >= 1){
                    for(let i = 0; i < new_edges.length; i+=2){
                        let node1 = this.graph_.getNodeByUsername(new_edges[i][0]);
                        let node2 = this.graph_.getNodeByUsername(new_edges[i][1]);
                        node1.addConnection(node2);
                    }
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
            console.log(data);
            try {
                data = JSON.parse(data);
            } catch {
                console.log("Don't need json?");
            }
            if(data['status'] == 'success'){
                window.selfnode.addConnection(this.graph_.getNodeByUsername(incomming_username));
                // alert("Success!");
            } else {
                console.log(data);
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