// JavaScript Document
minipollanswer_html_template = '<div class="minipollanswercontainer" data-mipoanswerid="{{{mipoanswerid}}}">\n';
minipollanswer_html_template += '<input class="mipoanswerinput" type="radio" value="ans{{{mipoanswerid}}}_ques{{{mipoquestionid}}}_mipo{{{mipoid}}}" name="ques{{{mipoquestionid}}}_mipo{{{mipoid}}}" id="ques{{{mipoquestionid}}}_mipo{{{mipoid}}}"  data-radio-id="ans{{{mipoanswerid}}}_ques{{{mipoquestionid}}}_mipo{{{mipoid}}}"/>';
minipollanswer_html_template +='{{{ans_text}}}\n';
minipollanswer_html_template +='</div>\n';