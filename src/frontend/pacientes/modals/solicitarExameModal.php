<!-- Modal para solicitar exames -->
<div class="modal fade" id="solicitarExameModal" tabindex="-1" role="dialog" aria-labelledby="modal-solicitarExame-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-solicitarExame-label">Solicitar Novos Exames</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="processar_solicitacao.php" method="post">
                    <!-- Lista de opções de exames -->
                    <div class="form-group">
                        <label>Selecione os exames:</label>
                        <div class="form-check">
                            <?php
                            // Lista de opções de exames
                            $exames = [
                                "Hemograma Completo",
                                "Glicose Jejum",
                                "Ttog",
                                "Hbac",
                                "Frutosamina",
                                "Insulina",
                                "Ureia",
                                "Creatinina",
                                "AcidoUrico",
                                "Triglicerideos",
                                "Ldlc",
                                "Hdlc",
                                "Colesterol Total",
                                "Colesterol Nhdlc",
                                "Tgoast",
                                "Calcio",
                                "Tgpalt",
                                "Bilirrubina Totale Fracao",
                                "Fosfatase Alcalina",
                                "Ggt",
                                "Transferrina",
                                "Ferro",
                                "Ferritina"
                            ];
                            foreach ($exames as $exame) {
                                echo "<div class=\"form-check\"><input type=\"checkbox\" class=\"form-check-input\" id=\"$exame\" name=\"exames[]\" value=\"$exame\"><label class=\"form-check-label\" for=\"$exame\">" . ucfirst($exame) . "</label></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Solicitar Exame</button>
                </form>
            </div>
        </div>
    </div>
</div>
