<?php

declare(strict_types=1);

/**
 * LibreDTE: Biblioteca PHP (Núcleo).
 * Copyright (C) LibreDTE <https://www.libredte.cl>
 *
 * Este programa es software libre: usted puede redistribuirlo y/o modificarlo
 * bajo los términos de la Licencia Pública General Affero de GNU publicada por
 * la Fundación para el Software Libre, ya sea la versión 3 de la Licencia, o
 * (a su elección) cualquier versión posterior de la misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero SIN
 * GARANTÍA ALGUNA; ni siquiera la garantía implícita MERCANTIL o de APTITUD
 * PARA UN PROPÓSITO DETERMINADO. Consulte los detalles de la Licencia Pública
 * General Affero de GNU para obtener una información más detallada.
 *
 * Debería haber recibido una copia de la Licencia Pública General Affero de
 * GNU junto a este programa.
 *
 * En caso contrario, consulte <http://www.gnu.org/licenses/agpl.html>.
 */

namespace libredte\lib\Core\Package\Billing\Component\TradingParties\Service;

use libredte\lib\Core\Package\Billing\Component\TradingParties\Contract\EmisorFactoryInterface;
use libredte\lib\Core\Package\Billing\Component\TradingParties\Contract\EmisorInterface;
use libredte\lib\Core\Package\Billing\Component\TradingParties\Contract\EmisorProviderInterface;

/**
 * Proveedor estricto de emisor.
 *
 * No inyecta valores "fake" ni completa campos automáticamente. Si faltan
 * datos obligatorios del emisor, se debe resolver en la capa de aplicación.
 */
class StrictEmisorProvider implements EmisorProviderInterface
{
    /**
     * Constructor del servicio y sus dependencias.
     *
     * @param EmisorFactoryInterface $emisorFactory
     */
    public function __construct(private EmisorFactoryInterface $emisorFactory)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function retrieve(int|string|EmisorInterface $emisor): EmisorInterface
    {
        // Si se pasó el RUT se crea una instancia mínima del emisor.
        if (is_int($emisor) || is_string($emisor)) {
            $emisor = $this->emisorFactory->create(['rut' => $emisor]);
        }

        // Se retorna tal cual, sin completar datos por defecto.
        return $emisor;
    }
}
