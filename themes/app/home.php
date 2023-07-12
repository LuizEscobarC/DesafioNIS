<?php $this->layout("_theme"); ?>
    <div class="app_main_box">
        <section class="app_main_left">
            <article class="app_widget">
                <header class="app_widget_title">
                    <h2 class="icon-info">Passo a Passo para navegar:</h2>
                </header>
                <h3>O item desafio do menu a esqueda corresponde a questão do desafio.</h3>
            </article>
            <article class="app_widget">
            <h3>Observações:</h3>
                <ol>
                    <li>Utilizei alguns design patterns, utilizei documentação somente nos métodos pois segui a técnica de descrição
                        de nome de alguns métodos igual ao recomendado no livro CleanCode.</li>
                    <li>Tive somente 1 dia para produzir o desafio então tentei me atentar ao máximo nos detalhes, porém foi algo simples e não houve muita complexidade.</li>
                    <li>Não utilizei o ateste unitário pois utilizei uma vez em projetos Laravel e não tive tempo de estudar e aplicar nesse projeto.</li>
                    <li>Utilizei o conceito de FAT MODEL onde a regra de negócio se concentra no modelo para reutilizar em outras APIS.</li>
                    <li>Refatorei os métodos com DRY (dont repeat yourself).</li>
                    <li> Não utilizei required nas tags para apresentar os tratamentos do backend</li>
                </ol>
                <hr>
                <i style="font-size: 0.8em;"> Detalhes importam, vale a pena esperar e fazê-los direito.
                <b>Steve Jobs</b></i>
            </article>

        </section>
    </div>

<?php $this->start("scripts"); ?>
<?php $this->end(); ?>