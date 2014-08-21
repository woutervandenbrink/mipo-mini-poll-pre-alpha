// JavaScript Document
minipollanswerresult_html_template = '<div class="minipollanswerresultcontainer {{{votedthisclass}}}" data-mipoanswerid="ans{{{mipoanswerid}}}_ques{{{mipoquestionid}}}_mipo{{{mipoid}}}" {{{votedthispart}}}>\n';
minipollanswerresult_html_template +='{{{ans_text}}}\n<br />';
minipollanswerresult_html_template +='  <div class="percentholder">\n';
minipollanswerresult_html_template +='  <span class="percentouter">\n';
minipollanswerresult_html_template +='    <span class="percentinner" style="width:{{{partvoted}}}%">\n';
minipollanswerresult_html_template +='    </span>\n';
minipollanswerresult_html_template +='  </span>\n';
minipollanswerresult_html_template +='  <span class="percent">\n';
minipollanswerresult_html_template +='    '+ ('{{{partvoted}}}') + '%';//(((100*('{{{}}})').toFixed(0))+
minipollanswerresult_html_template +='  </span>\n';
minipollanswerresult_html_template +='  </div>\n';
minipollanswerresult_html_template +='</div>\n';