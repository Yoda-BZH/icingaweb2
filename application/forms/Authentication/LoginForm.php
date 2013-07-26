<?php
// {{{ICINGA_LICENSE_HEADER}}}
/**
 * Icinga 2 Web - Head for multiple monitoring frontends
 * Copyright (C) 2013 Icinga Development Team
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * @copyright 2013 Icinga Development Team <info@icinga.org>
 * @author Icinga Development Team <info@icinga.org>
 */
// {{{ICINGA_LICENSE_HEADER}}}

namespace Icinga\Form\Authentication;

use Icinga\Web\Form;

/**
 * Class LoginForm
 */
class LoginForm extends Form
{
    /**
     * Interface how the form should be created
     */
    protected function create()
    {
        $this->addElement(
            'text',
            'username',
            array(
                'label'    => t('Username'),
                'required' => true
            )
        );

        $this->addElement(
            'password',
            'password',
            array(
                'label'    => t('Password'),
                'required' => true
            )
        );

        $this->addElement(
            'submit',
            'submit',
            array(
                'label' => t('Login'),
                'class' => 'pull-right'
            )
        );

        $this->setTokenDisabled(true);
    }
}
