// JavaScript Document
minipollanswer_html_template = '<div class="minipollanswercontainer" data-mipoanswerid="{{{mipoanswerid}}}">';
minipollanswer_html_template += '<input class="mipoanswerinput" {{{disabledattr}}} type="radio" value="ans{{{mipoanswerid}}}_ques{{{mipoquestionid}}}_mipo{{{mipoid}}}" name="ques{{{mipoquestionid}}}_mipo{{{mipoid}}}" id="ques{{{mipoquestionid}}}_mipo{{{mipoid}}}"  data-radio-id="ans{{{mipoanswerid}}}_ques{{{mipoquestionid}}}_mipo{{{mipoid}}}"/>';
minipollanswer_html_template +='<span class="answertext">{{{ans_text}}}</span>';
minipollanswer_html_template +='</div>\n';