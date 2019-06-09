import React, { Component } from 'react'
import { Card, CardBody, Col, Row, Table, Button } from 'reactstrap';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class Privilleges extends Component {
    constructor(props) {
        super(props);

        this.state = {
            depts: [],
            id: "",
            setting: {
                users_allow_create_disposition: [],
                users_allow_create_outbox: []
            },
            dept: {
                permissions: {},
                id : 0
            }
        }

        this.getDepts = this.getDepts.bind(this);
        this.getDept = this.getDept.bind(this);
        this.getSetting = this.getSetting.bind(this);
        this.updatePermission = this.updatePermission.bind(this);
    }
    componentDidMount() {
        this.getDepts();
        this.getSetting();
    }

    getDepts() {
        axios.get('/api/departments').then(({ data: depts }) => {
            this.setState({ depts });
        });
    }

    getDept() {
        axios.get(`/api/departments/${this.state.id}`).then(({ data: dept }) => this.setState({ dept }))
    }

    getSetting() {
        axios.get('/api/setting').then(({ data: setting }) => this.setState({ setting }));
    }

    onSelectDept(ev) {
        this.setState({ id: ev.target.value }, this.getDept);
    }

    onCheckboxClick(ev) {
        // console.log(ev.target.checked)
        const { dept } = this.state;
        dept.permissions[ev.target.name] = ev.target.checked;
        this.setState({ dept }, this.updatePermission);
    }

    updatePermission() {
        axios.put(`/api/department/${this.state.dept.id}`, {
            permissions : this.state.dept.permissions
        }).then(({ data }) => console.log(data));
    }

    render() {
        const { setting, depts, dept } = this.state;
        return (
            <Card>
                <CardBody>
                    <Row>
                        <Col md="6" lg={6}>
                            <select name="" onChange={this.onSelectDept.bind(this)} value={this.state.id} className="form-control" id="">
                                <option value="">-- Pilih Jabatan --</option>
                                {this.state.depts.map(dept => <option key={dept.id} value={dept.id}>{dept.name}</option>)}
                            </select>
                            <hr />
                            {Object.keys(dept.permissions).length > 0 && <Preference onClick={this.onCheckboxClick.bind(this)} {...dept.permissions} />}
                        </Col>
                        <Col md={6} lg={6}>
                            <label className="my-2">Buat Disposisi</label>
                            <select name="" onChange={this.onSelectDept.bind(this)} value={this.state.id} className="form-control" id="">
                                <option value="">-- Pilih Jabatan --</option>
                                {/* {this.state.depts.map(dept => <option key={dept.id} value={dept.id}>{dept.name}</option>)} */}
                                {depts.filter(dept => (!setting.users_allow_create_disposition.includes(dept.id))).map(dept => (<option value={dept.id} key={dept.id}>{dept.name}</option>))}
                            </select>
                            <Table bordered hover striped>
                                <thead>
                                    <tr>
                                        <th>Jabatan</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {depts.filter(dept => (setting.users_allow_create_disposition.includes(dept.id))).map(dept => (<tr key={dept.id}>
                                    <td>{dept.name}</td>
                                    <td><Button color="danger" size="sm"><i className="fa fa-trash fa-lg"></i></Button></td>
                                    </tr>))}
                                </tbody>
                            </Table>
                            <hr/>
                            <label className="my-2">Buat Surat Keluar</label>
                            <select name="" onChange={this.onSelectDept.bind(this)} value={this.state.id} className="form-control" id="">
                                <option value="">-- Pilih Jabatan --</option>
                                {/* {this.state.depts.map(dept => <option key={dept.id} value={dept.id}>{dept.name}</option>)} */}
                                {depts.filter(dept => (!setting.users_allow_create_outbox.includes(dept.id))).map(dept => (<option value={dept.id} key={dept.id}>{dept.name}</option>))}
                            </select>
                        </Col>
                    </Row>
                </CardBody>
            </Card>
        )
    }
}

const Preference = props => (
    <ul>
        <li><label><input type="checkbox" name="view" onChange={props.onClick} checked={props.view} id="" />&nbsp;Lihat disposisi</label></li>
        <li><label><input type="checkbox" name="edit" onChange={props.onClick} checked={props.edit} id="" />&nbsp;Edit disposisi</label></li>
        <li><label><input type="checkbox" name="forward.in" onChange={props.onClick} checked={props['forward.in']} id="" />&nbsp;Forward Disposisi Masuk</label></li>
        <li><label><input type="checkbox" name="forward.out" onChange={props.onClick} checked={props['forward.out']} id="" />&nbsp;Forward Disposisi Keluar</label></li>
    </ul>
)

if (document.getElementById('privillege')) {
    ReactDOM.render(<Privilleges />, document.getElementById('privillege'));
}
