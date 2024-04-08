import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend } from 'recharts';

const Widget = () => {
  const [ apiData, setApiData ] = useState();
  const url = `${mrsReactChartView.apiUrl}/mrsrc/v1/info`;

  useEffect( () => {
    axios.get(url).then( (res) => { setApiData(res.data) });
  }, []);

  const data = apiData;
  const onChangeSelect = (e) => {
    const furl = `${mrsReactChartView.apiUrl}/mrsrc/v1/last-n-days/${e.target.value}`;
    axios.get(furl).then( (res) => { setApiData(res.data) });
  }

  return (
    <div>
      <div>
        <h2 style={{display: "inline-block"}}>React Charts</h2>
          <select style={{display: "inline-block", float: "right"}} onChange={onChangeSelect}>
            <option value="7">7 Days</option>
            <option value="15">15 Days</option>
            <option value="30">30 Days</option>
          </select>
      </div>
        <LineChart
            width={400}
            height={300}
            data={data}
            margin={{
                top: 5,
                right: 30,
                left: 5,
                bottom: 5
            }}
            >
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey="name" />
            <YAxis />
            <Tooltip />
            <Legend />
            <Line
                type="monotone"
                dataKey="pv"
                stroke="#8884d8"
                activeDot={{ r: 8 }}
            />
            <Line type="monotone" dataKey="uv" stroke="#82ca9d" />
        </LineChart>
    </div>
  )
}

export default Widget