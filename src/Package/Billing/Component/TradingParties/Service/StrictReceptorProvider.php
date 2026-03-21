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

use libredte\lib\Core\Package\Billing\Component\TradingParties\Contract\ReceptorFactoryInterface;
use libredte\lib\Core\Package\Billing\Component\TradingParties\Contract\ReceptorInterface;
use libredte\lib\Core\Package\Billing\Component\TradingParties\Contract\ReceptorProviderInterface;

/**
 * Proveedor estricto de receptor.
 *
 * No inyecta valores "fake" ni completa campos automáticamente. Si faltan
 * datos obligatorios del receptor, se debe resolver en la capa de aplicación.
 */
class StrictReceptorProvider implements ReceptorProviderInterface
{
    /**
     * Constructor del servicio y sus dependencias.
     *
     * @param ReceptorFactoryInterface $receptorFactory
     */
    public function __construct(private ReceptorFactoryInterface $receptorFactory)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function retrieve(int|string|ReceptorInterface $receptor): ReceptorInterface
    {
        // Si se pasó el RUT se crea una instancia mínima del receptor.
        if (is_int($receptor) || is_string($receptor)) {
            $receptor = $this->receptorFactory->create(['rut' => $receptor]);
        }

        // Se retorna tal cual, sin completar datos por defecto.
        return $receptor;
    }
}
