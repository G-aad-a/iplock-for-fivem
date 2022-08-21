const fetch = require('node-fetch')
const config = require('../config.json')
const { MessageEmbed } = require('discord.js')
var { isGenAllowed, sendWebhook } = require("../Functions.js");
module.exports.run = async(client, message, args) => {
    
    if(!isGenAllowed(message)) {
        return message.reply(":/")
    }


    //message.delete();
    let type = args[0]
    let script_id = args[1]


    var embed = new MessageEmbed().setColor("BLACK")

    if (!type) return message.channel.send(embed.setDescription('You need to provide a type \`\`\`Lifetime & Month & Week & Day\`\`\`'));
    if (!script_id) return message.channel.send(embed.setDescription('You Need To Provide a script pack id!'));

    try {
        await fetch(`http://${config.host}/action.php?action=genKey&type=${type}&id=${script_id}&author=${message.author.id}`)
            .then(res => res.json())
            .then(json => {
                if(json["code"] !== undefined || json["code"] == 12005) {
                    message.channel.send(embed.setDescription("Thats not a valid type"))
                } else {
                    message.reply(new MessageEmbed().setTitle("Key Generation").setDescription("KEY: " + json["key"]))
                    console.log(`${message.author.tag} generated a key! - ${json['key']} - ${type}`  );
                }
                
            })
        
    } catch (e) {
        console.log(e)
        let embed = new MessageEmbed()
            .setColor("BLACK")
            .setDescription(`\`\`\`js
            
            ${e}

            \`\`\``)
        message.channel.send(embed)
    }
}