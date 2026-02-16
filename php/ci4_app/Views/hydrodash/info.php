<div class="content">
<div class="container-fluid mt-3 mb-4 pb-4">
    <b class="card-title m-auto ms-2" style="font-size: 1.2em">Berechnungsgrundlage</b><br />
    <small class="text-secondary ms-2 mt-2">Stand: 27.01.2026</small>

    <div class="card justify-content-center mt-4" id="discharge">
      <div class="card-header" style="background-color: #EBF2FA;">Abfluss und Quellschüttung</div>
      <div class="card-body">
        <p>Die Abweichung für Abfluss und Quellschüttung wird in [%] angegeben. Der Betrachtungszeitraum wird als Mittelwert repräsentiert.</p>

        <div class="m-5">
            <math class="my_math">
            <mn>Prozent</mn>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mstyle scriptlevel="0">
                        <mo>(</mo>
                        <mi>Wert</mi>
                        <mo>-</mo>
                        <mi>Grundwert</mi>
                        <mo>)</mo>
                    </mstyle>
                </mrow>
                <mrow>
                    <mstyle scriptlevel="0">
                        <mo>|</mo>
                        <mi>Grundwert</mi>
                        <mo>|</mo>
                    </mstyle>
                </mrow>
            </mfrac>
            <mo>*</mo>
            <mi>100</mi>
            </math>
        </div>

        <table class="table table-borderless mb-0 ms-0" style="width: auto !important; margin-left: 0px !important;">
            <tr>
                <td>Wert</td>
                <td>...</td>
                <td>aktueller Mittelwert des Betrachtungszeitraums<br /><span class="text-secondary">e.g. &#8709; 01.01.2025 - 05.09.2025</span></td>
            </tr>
            <tr>
                <td>Grundwert</td>
                <td>...</td>
                <td>langjährige Mittelwert des Betrachtungszeitraum<br /><span class="text-secondary">e.g. &#8709; der Jahre 1991, 1992, ... 2019, 2020 im Zeitraum 01.01 - 05.09.<br />bei Grundwert = 0 wird + / - &#8734; angezeigt</span></td>
            </tr>
        </table>
      </div>
    </div>

    <div class="card justify-content-center mt-3" id="precip">
      <div class="card-header" style="background-color: #EBF2FA;">Niederschlag</div>
      <div class="card-body">
        <p>Die Abweichung für Niederschlag wird in [%] angegeben. Der Betrachtungszeitraum wird als Summe bzw. dem Mittelwert der Summen der langjährigen Periode repräsentiert.</p>

        <div class="m-5">
            <math class="my_math">
            <mn>Prozent</mn>
            <mo>=</mo>
            <mfrac>
                <mrow>
                    <mstyle scriptlevel="0">
                        <mo>(</mo>
                        <mi>Wert</mi>
                        <mo>-</mo>
                        <mi>Grundwert</mi>
                        <mo>)</mo>
                    </mstyle>
                </mrow>
                <mrow>
                    <mstyle scriptlevel="0">
                        <mo>|</mo>
                        <mi>Grundwert</mi>
                        <mo>|</mo>
                    </mstyle>
                </mrow>
            </mfrac>
            <mo>*</mo>
            <mi>100</mi>
            </math>
        </div>

        <table class="table table-borderless mb-0" style="width: auto !important;">
            <tr>
                <td>Wert</td>
                <td>...</td>
                <td>aktuelle Summe des Betrachtungszeitraums<br /><span class="text-secondary">e.g. &#8721; 01.01.2025 - 05.09.2025</span></td>
            </tr>
            <tr>
                <td>Grundwert</td>
                <td>...</td>
                <td>langjähriger Mittelwert der Summen des Betrachtungszeitraum<br /><span class="text-secondary">e.g. &#8709; der Jahre 1991, 1992, ... 2019, 2020 der &#8721; im Zeitraum 01.01 - 05.09.<br />bei Grundwert = 0 wird + / - &#8734; angezeigt</span></td>
            </tr>
        </table>
      </div>
    </div>

    <div class="card justify-content-center mt-3" id="temp">
      <div class="card-header" style="background-color: #EBF2FA;">Wassertemperatur und Lufttemperatur</div>
      <div class="card-body">
        <p>Die Abweichung für Temperatur wird in [°C] angegeben.</p>

        <div class="m-5">
            <math class="my_math">
            <mn>Delta</mn>
            <mo>=</mo>
            <mi>Wert</mi>
            <mo>-</mo>
            <mi>Grundwert</mi>
            </math>
        </div>

        <table class="table table-borderless" style="width: auto !important;">
            <tr>
                <td>Wert</td>
                <td>...</td>
                <td>aktueller Mittelwert des Betrachtungszeitraums<br /><span class="text-secondary">e.g. &#8709; 01.01.2025 - 05.09.2025</span></td>
            </tr>
            <tr>
                <td>Grundwert</td>
                <td>...</td>
                <td>langjähriger Mittelwert des Betrachtungszeitraum<br /><span class="text-secondary">e.g. &#8709; der Jahre 1991, 1992, ... 2019, 2020 im Zeitraum 01.01 - 05.09.</span></td>
            </tr>
        </table>

        <p>Für Lufttemperatur wird das Tagesmittel nach Berechnung der Hydrographischen Dienste Österreich ausgewertet (&#8709; der Lufttemperatur von 07:00, 14:00 und 21:00 Uhr)</p>
      </div>
    </div>

    <div class="card justify-content-center mt-3" id="gw">
      <div class="card-header" style="background-color: #EBF2FA;">Lufttemperatur - Kenntage</div>
      <div class="card-body">
        <p>Kenntage werden anhand der minimalen- und maximalen Tagestemperaturen ermittelt:</p>
        <table class="table table-borderless" style="width: auto !important;">
            <tr>
                <td>Hitzetag</td>
                <td>...</td>
                <td>Max. T<sub>d</sub> > 30 °C</td>
            </tr>
            <tr>
                <td>Tropennacht</td>
                <td>...</td>
                <td>Min. T<sub>d</sub> > 20 °C</td>
            </tr>
            <tr>
                <td>Frosttag</td>
                <td>...</td>
                <td>Min. T<sub>d</sub> < 0 °C</td>
            </tr>
            <tr>
                <td>Eistag</td>
                <td>...</td>
                <td>Max. T<sub>d</sub> < 0 °C</td>
            </tr>
        </table>

        <p class="text-secondary mt-4 fst-italic">Quelle und weiterführende Literatur:</p>
        <p>Hohenwallner-Ries D., Schwab K., Huber T., Offenzeller M., Prutsch A. (2018): Factsheets der Lernwerkstatt Klimawandelanpassung. Bundesministerium für Land- und Forstwirtschaft, Umwelt und Wasserwirtschaft, Wien.<br />DOI: <a class="link-dark" href="https://doi.org/10.60669/spz6-4a43">https://doi.org/10.60669/spz6-4a43</a> (Abruf am 22.01.2026).</p>
        <p>Land Kärnten (2012): Klimaatlas Kärnten. Klimaperiode 1971-2000. Land Kärnten / Abteilung 8 - Umwelt, Naturschutz und Klimaschutzkoordination, Klagenfurt.<br />URL: <a class="link-dark" href="https://www.data.gv.at/katalog/datasets/173e0b38-4136-420e-bd67-2a3f960b616b">https://www.data.gv.at/katalog/datasets/173e0b38-4136-420e-bd67-2a3f960b616b</a> (Abruf am 27.01.2026).</p>
        </div>
    </div>  

    <div class="card justify-content-center mt-3" id="gw">
      <div class="card-header" style="background-color: #EBF2FA;">Grundwasser</div>
      <div class="card-body">
        <p>Die Abweichung für Grundwasser wird in [%] angegeben. Der aktuelle Wert wird dem Min., Mittel und Max. der langjährigen Periode gegenübergestellt.</p>

        <p class="text-secondary">Abweichung wenn aktueller Wert > langjähriger Mittelwert (positiv):</p>
        <div class="ms-5 mt-4 mb-5">
        <math class="my_math">
        <msub>
            <mn>Prozent</mn>
            <mn style="color: #fd5c63; margin-left: 0.5em;">pos.</mn>
        </msub>
        <mo>=</mo>
        <mfrac>
            <mrow>
                <mstyle scriptlevel="0">
                    <mo>(</mo>
                    <mi>Wert</mi>
                    <mo>-</mo>
                    <mi>Grundwert Mittel</mi>
                    <mo>)</mo>
                </mstyle>
            </mrow>
            <mrow>
                <mstyle scriptlevel="0">
                    <mo>(</mo>
                    <mi>Grundwert Max</mi>
                    <mo>-</mo>
                    <mi>Grundwert Mittel</mi>
                    <mo>)</mo>
                </mstyle>
            </mrow>
        </mfrac>
        <mo>*</mo>
        <mi>100</mi>
        </math>
        </div>

        <p class="text-secondary">Abweichung wenn aktueller Wert < langjähriger Mittelwert (negativ):</p>
        <div class="ms-5 mt-4 mb-5">
        <math class="my_math">
        <msub>
            <mn>Prozent</mn>
            <mn style="color: #6495ED; margin-left: 0.5em;">neg.</mn>
        </msub>
        <mo>=</mo>
        <mfrac>
            <mrow>
                <mstyle scriptlevel="0">
                    <mo>(</mo>
                    <mi>Wert</mi>
                    <mo>-</mo>
                    <mi>Grundwert Mittel</mi>
                    <mo>)</mo>
                </mstyle>
            </mrow>
            <mrow>
                <mstyle scriptlevel="0">
                    <mo>(</mo>
                    <mi>Grundwert Mittel</mi>
                    <mo>-</mo>
                    <mi>Grundwert Min</mi>
                    <mo>)</mo>
                </mstyle>
            </mrow>
        </mfrac>
        <mo>*</mo>
        <mi>100</mi>
        </math>
        </div>

        <table class="table table-borderless" style="width: auto !important;">
            <tr>
                <td>Wert</td>
                <td>...</td>
                <td>aktueller Mittelwert des Betrachtungszeitraums<br /><span class="text-secondary">e.g. &#8709; 01.01.2025 - 05.09.2025</span></td>
            </tr>
            <tr>
                <td>Grundwert Min</td>
                <td>...</td>
                <td>langjähriges Minimum des Betrachtungszeitraums<br /><span class="text-secondary">e.g. Mininimale Tageswerte der Jahre 1991, 1992, ... 2019, 2020, &#8709; aller min. Tageswerte des Zeitraums 01.01. - 05.09.</span></td>
            </tr>
            <tr>
                <td>Grundwert Mittel</td>
                <td>...</td>
                <td>langjähriger Mittelwert des Betrachtungszeitraums<br /><span class="text-secondary">e.g. &#8709; der Jahre 1991, 1992, ... 2019, 2020 im Zeitraum 01.01 - 05.09.</span></td>
            </tr>
            <tr>
                <td>Grundwert Max</td>
                <td>...</td>
                <td>langjähriges Maximum des Betrachtungszeitraums<br /><span class="text-secondary">e.g. Maximale Tageswerte der Jahre 1991, 1992, ... 2019, 2020, &#8709; aller max. Tageswerte des Zeitraums 01.01. - 05.09.</span></td>
            </tr>
        </table>
        <p class="text-secondary"><small>Beispiel:</small></p>
        <img src="<?php echo base_url(); ?>css/images/gw_descr.svg"></img>
        <p>Hinweis: Da der Mittelwert i.d.R. nicht exakt zwischen Minimum und Maximum liegt, sind die Abweichungen im positiven und negativen Bereich meistens unterschiedlich groß.<br />
        <span class="text-secondary">&#8594; 1 % im positiven Bereich entspricht einem anderen Wert als 1 % im negativen Bereich.</span></p>
    </div>    
    </div>

    <div class="card justify-content-center mt-3" id="aggregation">
      <div class="card-header" style="background-color: #EBF2FA;">Aggregation in Tageswerte</div>
      <div class="card-body">
        <p>Im Dashboard werden Tageswerte angezeigt und ausgewertet. Die Aggregation der Tageswerte erfolgt nach Tabelle 1.

        <table class="table table-hover table-condensed">
            <caption class="mt-1"><small>Tabelle 1: Aggregation der Tageswerte nach Parameter</small></caption>
            <thead>
                <tr>
                    <th style="width: 15%;">Parameter</th>
                    <th style="width: 15%;">Einheit</th>
                    <th style="width: 15%;">Startzeitpunkt</th>
                    <th style="width: 15%;">Aggregation</th>
                    <th>Anmerkung</th>
                </tr>
            </thead>
            <tr>
                <td>Abfluss</td>
                <td>m³ / s</td>
                <td>00:00 Uhr</td>
                <td>Mittel</td>
                <td></td>
            </tr>
            <tr>
                <td>Wassertemperatur</td>
                <td>°C</td>
                <td>00:00 Uhr</td>
                <td>Mittel</td>
                <td></td>
            </tr>
            <tr>
                <td>Niederschlag</td>
                <td>mm</td>
                <td>07:00 Uhr</td>
                <td>Summe</td>
                <td></td>
            </tr>
            <tr>
                <td>Lufttemperatur</td>
                <td>°C</td>
                <td>00:00 Uhr</td>
                <td>Mittel</td>
                <td>Mittlere Temperatur der Zeitpunkte 07:00, 14:00 und 21:00 Uhr<br /><span class="text-secondary">= (T<sub>07</sub> + T<sub>14</sub> + T<sub>21</sub>) / 3<br />Methode der Hydrographischen Dienste in Österreich</span></td>
            </tr>
            <tr>
                <td>Lufttemperatur - Kenntage</td>
                <td>°C</td>
                <td>00:00 Uhr</td>
                <td>Min. / Max.</td>
                <td>
                    Hitzetag: Max. T<sub>d</sub> > 30 °C<br />
                    Tropennacht: Min. T<sub>d</sub> > 20 °C<br />
                    Frosttag: Min. T<sub>d</sub> < 0 °C<br />
                    Eistag: Max. T<sub>d</sub> < 0 °C
                </td>
            </tr>
            <tr>
                <td>Grundwasser</td>
                <td>m.ü.A.</td>
                <td>00:00 Uhr</td>
                <td>Mittel</td>
                <td>Statistische Berechnung für Flurabstände<br /><span class="text-secondary">= Geländeoberkante - Grundwasserstand in [m]<br />Umrechnung in Grafik nach Grundwasserstand in [m.ü.A.]</td>
            </tr>
            <tr>
                <td>Quellen</td>
                <td>l / s</td>
                <td>00:00 Uhr</td>
                <td>Mittel</td>
                <td></td>
            </tr>
        </table>
      </div>    
    </div>

    <div class="card justify-content-center mt-3" id="gaps">
      <div class="card-header" style="background-color: #EBF2FA;">Kein Messwert</div>
      <div class="card-body">
        <p>Ab einem Lückenanteil > 5% wird die Auswertung verworfen.</p>
        <p class="text-secondary">Bsp.: In einem Betrachtungszeitraum von 100 Tagen müssen min. 95 Tage vollständig erfasst sein. Sind weniger als 95 Tage erfasst, wird "Kein Messwert" angezeigt.</p>
      </div>
    </div>

    <div class="card justify-content-center mt-3" id="gaps">
      <div class="card-header" style="background-color: #EBF2FA;">Ungeprüfte Rohdaten</div>
      <div class="card-body">
        <p>
            Die Inhalte des Dashboards werden kontinuierlich geprüft. Trotzdem kommt es zur Veröffentlichung fehlerhafter Messwerte. Wird dies erkannt, wird die Station aus dem Service entfernt. <br />
            Bitte beachten Sie, dass trotz Prüfung fehlerhafte Werte publiziert werden. Die Messwerte entsprechen <i>ungeprüften Rohdaten</i>.
        </p>
        <p>
            Für die Richtigkeit, Vollständigkeit und Verfügbarkeit wird keinerlei Haftung oder Gewährleistung übernommen.
        </p>
      </div>
    </div>

</div>
</div>
