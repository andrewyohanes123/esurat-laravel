import React, { Component } from "react";
import {UncontrolledDropdown, DropdownItem, DropdownMenu, DropdownToggle, Badge} from 'reactstrap';
import {FaBell, FaBellSlash, FaSyncAlt} from 'react-icons/fa'
import ReactDOM from 'react-dom';
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id'

export default class Notifications extends Component {
    constructor(props) {
        super(props);

        this.state = {
            notifications : [],
            count : 0
        }

        this.getNotifications = this.getNotifications.bind(this);
    }

    componentDidMount() {
        moment.locale('id');
        this.getNotifications();
    }


    getNotifications() {
        axios.get('/api/notifications')
        .then(({data : {data : notifications, count}}) => this.setState({ notifications, count }))
        .catch(err => alert("Please reload the page"));
    }

    render() {
        return (
        <>
        <UncontrolledDropdown nav>
            <DropdownToggle onClick={this.getNotifications} nav>
                <FaBell />
                {this.state.count > 0 && <Badge pill color="danger">{this.state.count}</Badge>}
            </DropdownToggle>
            <DropdownMenu className="shadow-sm" right>
                {this.state.notifications.length === 0 && 
                <DropdownItem disabled>
                    <p className="text-center text-muted m-0">Tidak ada notifikasi</p>
                    <h1 className="text-center my-2 text-muted"><FaBellSlash size="48px" /></h1>
                    <p className="small m-0">Silahkan periksa kembali</p>
                </DropdownItem>
                }
                { this.state.notifications.map(notif => (<DropdownItem href={`/dashboard/disposisi/surat/${notif.id}/in`} key={notif.id}>
                    <h6 className="m-0">Disposisi Baru</h6>
                    {/* <hr/> */}
                    <p className="text-muted m-0">{notif.from_user[0].name} mengirimi {notif.disposition.letter_sort} : {notif.disposition.reference_number}</p>
                    <p className="m-0 small">{moment(notif.created_at).format('dddd, DD MMMM YYYY hh:mm:ss')}</p>
                    <hr className="m-0"/>
                </DropdownItem>)) }
            </DropdownMenu>
        </UncontrolledDropdown>
        {/* <li className="nav-item"><a href="#" className="nav-link">Link</a></li> */}
        </>
        );
    }
}

if (document.getElementById('notification')) {
	ReactDOM.render(<Notifications />, document.getElementById('notification'))
}
