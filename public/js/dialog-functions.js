function dialogSolution(id, title, csrf, user) {
    Metro.dialog.create({
        width: "1000",
        overlayClickClose: true,
        title: "" + title + "",
        onShow: function (el) {
            el.addClass("ani-swoopInTop");
            setTimeout(function () {
                el.removeClass("ani-swoopInTop");
            }, 500);
        },
        onHide: function (el) {
            el.addClass("ani-swoopOutTop");
            setTimeout(function () {
                el.removeClass("ani-swoopOutTop");
            }, 500);
        },
        content: "<form id='formSolution' action='/bioclin/solutions' method='post'><input type='hidden' name='_token' value='"+csrf+"'/><input type='hidden' name='user_id' value='"+user+"'><input type='hidden' name='ticket_id' value='" + id + "'><textarea name='description'></textarea></form>" +
            "<div class='dialog-actions clear'><button class='button wide rounded js-dialog-close place-right'>Cancelar</button><button form='formSolution' class='button rounded success js-dialog-close place-right'>Salvar</button></div>",
    });
}


function dialogDetails(id,ticket, requerente, description, urgencyId, impactId, statusId, typeId, image, cName, dName) {
    var urgency = ['Null', 'Baixa', 'Média', 'Alta'];
    var impact = ['Null', 'Baixo', 'Médio', 'Alto'];
    var status = ['Null', 'Aberto', 'Processando', 'Pendente Fornecedor', 'Pendente Cliente', 'Fechado'];
    var type = ['Null', 'Incidente', 'Requisição'];
    var isImage = image ? '' : 'hidden';
    Metro.dialog.create({
        width: "1000",
        overlayClickClose: true,
        onShow: function (el) {
            el.addClass("ani-swoopInTop");
            setTimeout(function () {
                el.removeClass("ani-swoopInTop");
            }, 500);
        },
        onHide: function (el) {
            el.addClass("ani-swoopOutTop");
            setTimeout(function () {
                el.removeClass("ani-swoopOutTop");
            }, 500);
        },
        title: "<div class='place-left'>"+id+" - "+ticket+"</div>" ,
        content:"<label>Descrição</label><textarea rows='5' disabled>"+description+"</textarea>" +
            "<div class='row mt-1'>"+
                "<div class='cell-2'><label>Urgência</label><input type='text' value='"+urgency[urgencyId]+"' disabled/></div>"+
                "<div class='cell-2'><label>Impacto</label><input type='text' value='"+impact[impactId]+"' disabled/></div>"+
                "<div class='cell-2'><label>Tipo</label><input type='text' value='"+type[typeId]+"' disabled/></div>"+
                "<div class='cell-2'><label>Status</label><input type='text' value='"+status[statusId]+"' disabled/></div>"+
                "<div class='cell-2'><label>Departamento2</label><input type='text' value='"+dName+"' disabled/></div>"+
                "<div class='cell-2'><label>Categoria</label><input type='text' value='"+cName+"' disabled/></div>"+
            "</div>"+
            "<div class='img-container thumbnail h-25 w-25 mt-3 rounded' "+isImage+">"+
            "<img data-fancybox='gallery' href='/app/img/ticket/"+id+"/"+image+"' src='/app/img/ticket/"+id+"/"+image+"' alt='ticket'>"+
            "</div>"+
            "<div class='place-right mt-4'><p class='text-small text-muted'>Requerente: "+requerente+"</p></div>",
        actions: [
            {
                caption: "Editar",
                cls: "js-dialog-close primary",
                onclick: function(){
                    url = "http://172.16.101.30:3000/bioclin/tickets/"+id+"/edit";
                    $(location).attr("href", url);
                }
            },
            {
                caption: "Fechar",
                cls: "js-dialog-close",
                onclick: function(){
                    close();
                }
            }
        ]
    });
}