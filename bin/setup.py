#!/usr/bin/python

import sys
import json
import os

configPath = sys.argv[1];
with open(configPath) as data_file:
    data = json.load(data_file)

classesOutput = data["outputDirectory"];
classesNamespace = data["namespace"];
htaccessFilePath = data["htaccessFile"];
services = data["services"];

if not os.path.exists(classesOutput):
    os.makedirs(classesOutput)

for service in services:
    serviceName = service["name"];
    className = serviceName + "Service";
    serviceMethods = service["methods"];
    with open ("../template/RestServiceTemplate.php", "r") as handle:
        template = handle.read();
    template = template.replace("{{namespace}}", classesNamespace);
    template = template.replace("{{serviceName}}", className);
    with open(htaccessFilePath, "a+") as writer:
        writer.write("### " + serviceName + " ###\n");
    for method in serviceMethods:
        methodType = method["type"];
        methodContent = "\n";
        if not method['parameters']:
            methodContent += "\t\tServerUtils::sendStatus(HttpResponseCode::METHOD_NOT_ALLOWED, self::TERMINATE);\n"
        else:
            for parameter in method['parameters']:
                parameterName = parameter['name'];
                methodContent += "\t\t$" + parameterName + " = $request -> parameters['" + parameterName + "'];\n"
        methodContent += "\t";
        template = template.replace("{{" + methodType + "}}", methodContent);
        rewriteRule = "";
        rewriteCondition = "RewriteCond %{REQUEST_METHOD} " + methodType + "\n";
        if 'rewrite-rule' in method:
            rewriteRule = method['rewrite-rule'] + "\n";
        else:
            #RewriteRule ^([a-zA-Z0-9_-]+)$ index.php?__dispatch=$1 [QSA]
            rewriteRulePrefix = "RewriteRule ^" + serviceName.lower();
            rewriteRuleSuffix = "index.php?__dispatch=" + className;
            counter = 1;
            for parameter in method['parameters']:
                if parameter['type'] is "Integer":
                    rewriteRulePrefix += "\/([0-9]+)";
                else:
                    rewriteRulePrefix += "\/([a-zA-Z0-9_-]+)";
                rewriteRuleSuffix += "&" + parameter['name'] + "=$" + str(counter);
                counter = counter + 1;
            rewriteRule = rewriteRulePrefix + "$ " + rewriteRuleSuffix + " [QSA]\n";
        with open(htaccessFilePath, "a+") as writer:
            writer.write(rewriteCondition);
            writer.write(rewriteRule);
    with open(classesOutput + className + ".php", 'w+') as writer:
        writer.write(template);
